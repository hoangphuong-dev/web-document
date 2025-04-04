<?php

namespace App\Http\Controllers\Sepay;

use App\Exceptions\Api\ValidateFailedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SePay\SepayResponseRequest;
use App\Services\Payment\SepayService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SePayController extends Controller
{
    /**
     * @return Response
     */
    public function processResponse(SepayResponseRequest $request)
    {
        try {
            $sePayWebhookData = $request->validated();
            [$message, $headerCode] = SepayService::processResponse($sePayWebhookData);
            Log::info('sePayWebhookData', ['sePayWebhookData' => $sePayWebhookData]);
        } catch (ValidateFailedException $e) {
            [$message, $headerCode] = [$e->getMessage(), 302];
        } catch (Exception $e) {
            [$message, $headerCode] = [$e->getMessage(), $e->getCode()];
        }

        return response()->json(['message' => $message ?? 'Success'], $headerCode ?? 200);
    }
}
