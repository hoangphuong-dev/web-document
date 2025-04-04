<?php

namespace App\Services\Payment;

use App\Data\Payment\SePayWebhookData;
use App\Enums\Payment\NotLogin\MoneyStatus;
use App\Events\Payment\NotEnoughMoneyNotLogin;
use App\Models\SePayTransaction;
use Illuminate\Support\Arr;

class SepayService
{
    /**
     * Quy trình:
     *      1. Kiểm tra mã giao dịch từ đối tác đã xử lý thành công?
     *      2. Kiểm tra user_id
     *      3. Update thông tin giao dịch trong bảng giao dịch của hình thức
     *      4. Tiến hành cộng tiền
     *      5. Cộng tiền thành công -> dispatch event cộng tiền thành công
     *      6. Cộng tiền không thành công -> update lại trạng thái lỗi cho giao dịch trong bảng giao dịch của hình thức
     *
     * @param SePayWebhookData $sePayWebhookData
     * @return array
     */
    public static function processResponse(SePayWebhookData $sePayWebhookData): array
    {
        // Lấy thông tin từ đối tác trả về
        [$docId, $orderId, $guestId] = static::detectDescPayment($sePayWebhookData->content);

        // 1. check giao dịch đã được thực hiện chưa
        if (PaymentNotLoginService::checkTransactionProcessed($orderId)) {
            return ['The transaction has been processed', 200];
        }

        // 2. check giao dịch hợp lệ
        $order = PaymentNotLoginService::checkValidTransaction($orderId, $guestId);
        if (empty($orderId)) {
            return ["Not found user for order {$orderId}", 404];
        }

        // Tạo mới giao dịch sepay
        $transaction = static::createSePayTransaction($sePayWebhookData);
        $moneyAdd    = $transaction->transferAmount; // Tiền user chuyển vào tài khoản ngân hàng
        $moneyStatus = PaymentNotLoginService::checkMoney($order, $moneyAdd);

        // Thông báo nếu nạp không đủ tiền
        NotEnoughMoneyNotLogin::dispatchIf(MoneyStatus::LACK()->is($moneyStatus), $order, $moneyAdd);

        // 3. Update giao dịch trong bảng giao dịch. Hiện tại là MoneyNotLogin (update status, transID)
        if (!$order->update([
            'money'          => $moneyAdd,
            'status'         => $moneyStatus,
            'transaction_id' => $transaction->id,
        ])) {
            return ["Không thể cập nhật bản ghi", 500];
        }

        if (MoneyStatus::ENOUGH()->is($moneyStatus)) {
            // todo: 4. Cộng tiền cho người bán 
            // self::addMoneyForSeller($transaction->document);

            // Gửi tài liệu cho user và thông báo thành công
            PaymentNotLoginService::sendDocumentForUser($order);
        }
        return ['Success', 200];
    }

    /**
     * Tạo nội dung chuyển khoản theo docId, orderId, guestId
     *
     * @param int $orderId
     * @param int $guestId
     * @param int $docId
     *
     * @return string
     */
    public static function createDescPayment(int $orderId, int $guestId, int $docId): string
    {
        return config('sepay.pattern') . "{$docId}O{$orderId}U{$guestId}";
    }

    /**
     * Detect nội dung chuyển khoản để lấy theo thứ tự docId, orderId, guestId
     *
     * @param string $des
     *
     * @return array
     */
    public static function detectDescPayment(string $des): array
    {
        $patternSepay = config('sepay.pattern');
        if (preg_match("~{$patternSepay}(\d+)O(\d+)U(\d+)~", $des, $matches)) {
            return [
                Arr::get($matches, '1', ''),
                Arr::get($matches, '2', ''),
                Arr::get($matches, '3', ''),
            ];
        }
        return [];
    }

    public static function createSePayTransaction(SePayWebhookData $sePayWebhookData)
    {
        $model                  = new SePayTransaction();
        $model->id              = $sePayWebhookData->id;
        $model->gateway         = $sePayWebhookData->gateway;
        $model->transactionDate = $sePayWebhookData->transactionDate;
        $model->accountNumber   = $sePayWebhookData->accountNumber;
        $model->subAccount      = $sePayWebhookData->subAccount;
        $model->code            = $sePayWebhookData->code;
        $model->content         = $sePayWebhookData->content;
        $model->transferType    = $sePayWebhookData->transferType;
        $model->description     = $sePayWebhookData->description;
        $model->transferAmount  = $sePayWebhookData->transferAmount;
        $model->referenceCode   = $sePayWebhookData->referenceCode;
        $model->save();
        return $model;
    }
}
