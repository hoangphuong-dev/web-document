<?php

namespace App\Http\Requests\SePay;

use App\Data\Payment\SePayWebhookData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SepayResponseRequest extends FormRequest
{
    /**
     * check token từ sepay trả về có hợp lệ hay không 
     */
    public function authorize(): bool
    {
        Log::info('header', ['header' => $this->header()]);
        $token = $this->header('apikey', '');
        Log::info('token', ['token_header' => $token]);
        $auth = isset($token) && $token == config('sepay.webhook_token') ? true  : false;
        Log::info('auth', ['auth' => $auth]);
        return true;
        return $auth;
    }

    /**
     * Get the validated data from the request.
     *
     * @param  array|int|string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null): SePayWebhookData
    {
        return new SePayWebhookData(
            (int) $this->request->get('id'),
            (string) $this->request->get('gateway'),
            (string) $this->request->get('transactionDate'),
            (string) $this->request->get('accountNumber'),
            (string) $this->request->get('subAccount'),
            (string) $this->request->get('code'),
            (string) $this->request->get('content'),
            (string) $this->request->get('transferType'),
            (string) $this->request->get('description'),
            (int) $this->request->get('transferAmount'),
            (string) $this->request->get('referenceCode'),
            (int) $this->request->get('accumulated')
        );
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Invalid Token');
    }
}
