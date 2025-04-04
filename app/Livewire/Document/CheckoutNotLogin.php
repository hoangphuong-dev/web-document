<?php

namespace App\Livewire\Document;

use App\Data\Payment\RequestNotLoginData;
use App\Enums\Common\AlertType;
use App\Enums\Payment\NotLogin\MoneyStatus;
use App\Models\MoneyNotLogin;
use App\Services\Payment\PaymentNotLoginService;
use App\Services\Payment\SepayService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Component;

class CheckoutNotLogin extends Component
{
    public array $form;
    public array $accountTransfer = [];
    public int $documentId;
    public int|string $guestId;

    protected function rules(): array
    {
        return [
            'form.email' => ['required'],
            'form.phone' => ['required', 'regex:/^0[0-9]{9,10}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'form.email.required' => 'Email không được để trống.',
            'form.phone.required' => 'Số điện thoại không được để trống.',
            'form.phone.regex'    => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng.',
        ];
    }

    public function updatedForm(mixed $value, string $nested)
    {
        foreach (array_keys($this->form) as $key) {
            if ($key == $nested) {
                $this->resetValidation("form.{$nested}");
            }
        }
    }

    public function requestPayment()
    {
        $this->guestId = $guestId = PaymentNotLoginService::getUser($this->documentId);
        $validated = Arr::get($this->validate(), 'form', []);
        $requestNotLoginData = new RequestNotLoginData(
            $guestId,
            $this->documentId,
            Arr::get($validated, 'phone'),
            Arr::get($validated, 'email'),
            deviceCurrent()
        );

        // Đã thanh toán thành công => bật popup để user tải 
        // todo: check conditions
        $moneyNotLogin = MoneyNotLogin::where([
            'guest_id'    => $guestId,
            'document_id' => $this->documentId,
            'status'      => MoneyStatus::ENOUGH,
            'email'       => Arr::get($validated, 'email'),
        ])->where('created_at', '>=', Carbon::now()->subHours(6))->first();
        if ($moneyNotLogin) {
            return $this->dispatch('openModal', 'popup.payment.payment-sucess-not-login', [
                'data' => PaymentNotLoginService::encryptData([
                    'transaction' => $moneyNotLogin->id,
                ]),
            ]);
        }

        // Thêm row thanh toán không đăng nhập
        $order = PaymentNotLoginService::requestNotLogin($requestNotLoginData);

        // Lấy data của acc nhận tiền
        if (!empty($order)) {
            $description = SepayService::createDescPayment($order->id, $guestId, $this->documentId);

            $bank  = config('sepay.bank');
            $acc   = config('sepay.acc');
            $money = $order?->money_need ?? 20000;

            $this->accountTransfer['bank']        = $bank;
            $this->accountTransfer['acc']         = $acc;
            $this->accountTransfer['name']        = config('sepay.name');
            $this->accountTransfer['money']       = $order?->money_need ?? 50000;
            $this->accountTransfer['description'] = $description;
            $this->accountTransfer['qr_link']     = generate_qr($bank, $acc, $money, $description);
        } else {
            notify("Không tìm thấy account nhận tiền !", AlertType::ERROR);
        }
    }

    public function render()
    {
        return view('livewire.document.checkout-not-login');
    }
}
