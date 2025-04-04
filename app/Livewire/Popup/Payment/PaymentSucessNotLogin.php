<?php

namespace App\Livewire\Popup\Payment;

use Exception;
use Illuminate\Support\Arr;
use App\Models\MoneyNotLogin;
use App\Enums\Payment\NotLogin\MoneyStatus;
use App\Models\Document;
use App\Services\Document\DocumentStatisticService;
use App\Services\Payment\PaymentNotLoginService;
use App\Services\Storage\DiskPathService;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;
use TypeError;

class PaymentSucessNotLogin extends ModalComponent
{
    public string  $data;
    private string $error = '';

    public ?MoneyNotLogin $moneyNotLogin = null;
    public Document $document;

    public function mount()
    {
        $_data         = PaymentNotLoginService::decryptData($this->data);
        $requiredKeys  = 'transaction';
        $isValidData   = Arr::has($_data, $requiredKeys);

        if ($isValidData) {
            try {
                $this->moneyNotLogin = MoneyNotLogin::query()
                    ->with('document')
                    ->where([
                        'status' => MoneyStatus::ENOUGH,
                        'id'     => Arr::get($_data, 'transaction'),
                    ])
                    ->first();
                if (!$this->moneyNotLogin) {
                    $this->error = 'Giao dịch không tồn tại';
                } else {
                    $this->document = $this->moneyNotLogin->document;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = 'Dữ liệu không hợp lệ!';
        }
    }

    public function tmpDownload()
    {
        try {
            $document = $this->document;
            PaymentNotLoginService::checkDownload($this->moneyNotLogin);
            $path = "{$document->path}/{$document->file_name}";
            if (DiskPathService::document()->exists($path)) {
                $fileName = "[" . config('app.name') . "]{$document->slug}-{$document->file_name}";
                DocumentStatisticService::increment($document, 'number_download');
                $this->closeModal();
                return DiskPathService::document()->download($path, $fileName);
            }
        } catch (\Exception | TypeError $ex) {
            Log::error($ex->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.popup.payment.payment-sucess-not-login', [
            'error'           => $this->error,
            'transaction'     => $this->moneyNotLogin,
        ]);
    }
}
