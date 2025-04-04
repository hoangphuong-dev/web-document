<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class BaseAPIController extends Controller
{
    public static function apiResponse(int $code, string $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function success(mixed $data = [], string $message = ''): JsonResponse
    {
        return self::apiResponse(ResponseAlias::HTTP_OK, $message ?: 'Success!', $data);
    }

    public static function error(?string $message): JsonResponse
    {
        return self::apiResponse(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $message ?: 'Error!');
    }

    public static function info(mixed $data): JsonResponse
    {
        return response()->json([
            'data'    => $data,
        ], ResponseAlias::HTTP_ACCEPTED);
    }
}
