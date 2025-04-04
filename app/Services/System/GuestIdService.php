<?php

namespace App\Services\System;

use Exception;
use Hash\HashId;
use Illuminate\Support\Arr;

class GuestIdService
{

    /**
     * Tạo lại guest_id từ word_id
     *
     * @param  string  $guestId
     * @return string
     */
    public static function decodeGuestId(string $guestId): string
    {
        try {
            $handle = static::getHashHandler();
            return Arr::first($handle->decode($guestId), null, '');
        } catch (Exception) {
            return '';
        }
    }

    /**
     * Tạo hash id từ guestId
     *
     * @param  int  $guestId
     * @return string
     */
    public static function hashGuestId(int $guestId): string
    {
        try {
            $handle = static::getHashHandler();
            return $handle->encode($guestId);
        } catch (Exception) {
            return '';
        }
    }

    /**
     * @throws Exception
     */
    private static function getHashHandler(): HashId
    {
        $salt = date("Y-m");
        return new HashId($salt, 15, '0123456789');
    }
}
