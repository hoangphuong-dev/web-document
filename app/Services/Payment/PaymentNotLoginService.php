<?php

namespace App\Services\Payment;

use App\Data\Payment\RequestNotLoginData;
use App\Enums\Payment\NotLogin\MoneyStatus;
use App\Events\Payment\RechargeSuccessNotLogin;
use App\Exceptions\Document\DocumentError;
use App\Exceptions\Payment\NotEnoughMoney;
use Helpers\Formatter;
use App\Models\Document;
use App\Models\MoneyNotLogin;
use App\Models\UserGuest;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentStatisticService;
use App\Services\System\GuestIdService;
use App\Services\User\EmailService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class PaymentNotLoginService
{

    /**
     * Method requestNotLogin
     *
     * @param RequestNotLoginData $requestData
     *
     * @return MoneyNotLogin
     */
    public static function requestNotLogin(RequestNotLoginData $requestData): ?MoneyNotLogin
    {
        if ($document = DocumentService::first(docId: $requestData->docId, isPublish: true)) {
            [$money, $phoneNumber] = static::formatData(static::getMoneyNeed($document), $requestData->phone);

            // nếu tài liệu đang chưa thanh toán trong ngày thì không tạo mới row
            if ($checkOrder = static::moneyNotLoginPenddingInDay($requestData->guestId, $document->id)) {
                return $checkOrder;
            }

            return MoneyNotLogin::create([
                'guest_id'    => $requestData->guestId,
                'document_id' => $document->id,
                // 'order_id'    => $orderId,
                'money_need'  => $money,
                'phone'       => $phoneNumber,
                'email'       => $requestData->email,
                'ip'          => get_user_ip_address(),
                'device_type' => $requestData->deviceType,
                'description' => '',
            ]);
        }
        return null;
    }

    /**
     * Kiểm tra download và tạo link tải
     *
     * @throws DocumentIsError
     * @throws NotEnoughMoney
     */
    public static function checkDownload(MoneyNotLogin $transaction)
    {
        throw_if($transaction->money < $transaction->money_need, NotEnoughMoney::class);

        $document = $transaction->document;

        throw_if(!$document, DocumentError::class);

        throw_if($document->getMoneySell() > $transaction->money, NotEnoughMoney::class);

        // Thêm thống kê tải tài liệu
        DocumentStatisticService::increment($document, 'number_download');
        DocumentStatisticService::documentDownload($document->id, $transaction->guest_id);

        // self::createCookie($primaryId, $document->id);

        // return static::getUrlDownloadPage($document->id, $transaction->guest_id, $transaction->email);
    }

    /**
     * Tạo dữ liệu để download
     */
    private static function getUrlDownloadPage(int $documentId, string $guestId, string $email = ''): string
    {
        if ($email) {
            $parameter = [
                'email' => $email,
            ];
        }
        return DocumentService::urlDownloadOneTimePage($documentId, $guestId, $parameter ?? []);
    }

    /**
     * Get guest id
     *
     * @param  int  $docId
     * @return string
     */
    public static function getUser(int $docId): string
    {
        $cookieKey = 'is_guest';
        $timeCookie = 86400 * 30; // 1 tháng
        $guestId   = Cookie::get($cookieKey);

        if (!$guestId || !GuestIdService::decodeGuestId($guestId)) {
            $guestUser = UserGuest::create(['doc_id' => $docId]);
            $guestId   = $guestUser->id;
            $guestId   = GuestIdService::hashGuestId($guestId);
            Cookie::queue($cookieKey, $guestId, $timeCookie, '/');
        }
        return $guestId;
    }

    /**
     * Method formatData
     *
     * @param int $money
     * @param string $phoneNumber
     * @param bool $applyVat
     *
     * @return array
     */
    protected static function formatData(int $money, string $phoneNumber, bool $applyVat = true): array
    {
        return [
            $money * (1 + ($applyVat ? config('payment.vat') : 0)),
            Formatter::mapPhoneNumber($phoneNumber)
        ];
    }

    /**
     * Tính số tiền cần thanh toán
     *
     * @param  Document  $document
     * @return int
     */
    public static function getMoneyNeed(Document $document): int
    {
        $documentPrice = $document->getMoneySell();

        if ($documentPrice == 0) {
            return 10000;
        }
        return $documentPrice;
        // $arrayCard = config('payment.download_not_login.money_need', []);
        // foreach ($arrayCard as $value) {
        //     if ($documentPrice <= $value) {
        //         return $value;
        //     }
        // }
        // return $documentPrice;
    }

    /**
     * Lấy đơn hàng chưa được thanh toán trong ngày => trách tạo nhiều bản ghi
     *
     * @param int $guestId
     * @param $documentId $documentId
     *
     * @return MoneyNotLogin
     */
    public static function moneyNotLoginPenddingInDay(int $guestId, $documentId): ?MoneyNotLogin
    {
        return MoneyNotLogin::query()
            ->where([
                ['guest_id', $guestId],
                ['document_id', $documentId],
                ['status', MoneyStatus::PENDDING],
                ['created_at', '>', Carbon::now()->startOfDay()],
                ['created_at', '<', Carbon::now()->endOfDay()],
            ])->first();
    }

    public static function checkMoney(MoneyNotLogin $moneyNotLogin, int $money): int
    {
        $moneyNeed = $moneyNotLogin->money_need;
        if ($money < $moneyNeed) {
            return MoneyStatus::LACK;
        }
        return MoneyStatus::ENOUGH;
    }

    /**
     * Gửi tài liệu cho user guest => bật popup thông báo thanh toán thành công
     *
     * @param MoneyNotLogin $moneyNotLogin
     *
     * @return void
     */
    public static function sendDocumentForUser(MoneyNotLogin $moneyNotLogin): void
    {
        // if ($moneyNotLogin->email) {
        //     EmailService::sendDownloadOneTime($moneyNotLogin->email, $moneyNotLogin->document);
        // }
        // Broadcast data cho user guest
        RechargeSuccessNotLogin::dispatch($moneyNotLogin);
    }

    /**
     * Kiểm tra đơn hàng đã được thanh toán hay chưa
     *
     * @param int $orderId
     *
     * @return bool
     */
    public static function checkTransactionProcessed(int $orderId): bool
    {
        return MoneyNotLogin::query()
            ->useWritePdo()
            ->where([
                ['order_id', $orderId],
                ['status', '<>', MoneyStatus::ENOUGH],
            ])->exists();
    }

    /**
     * Kiểm tra xem đơn hàng có pendding hoặc chưa đủ tiền không
     *
     * @param int $orderId
     * @param int $guestId
     *
     * @return MoneyNotLogin
     */
    public static function checkValidTransaction(int $orderId, int $guestId): ?MoneyNotLogin
    {
        return MoneyNotLogin::query()
            ->useWritePdo()
            ->whereIn('status', [MoneyStatus::PENDDING, MoneyStatus::LACK])
            ->where([
                ['id', $orderId],
                ['guest_id', $guestId],
            ])->latest('created_at')->first();
    }

    /**
     * Mã hóa dữ liệu
     *
     * @param  array  $data
     * @return string
     */
    public static function encryptData(array $data): string
    {
        return Crypt::encrypt($data);
    }

    /**
     * Giải mã dữ liệu
     *
     * @param  string  $data
     * @return array
     */
    public static function decryptData(string $data): array
    {
        return Crypt::decrypt($data);
    }
}
