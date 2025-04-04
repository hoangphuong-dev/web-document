<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    public static function getUserByEmail(string $email)
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public static function getUserActiveByEmail(string $email)
    {
        return User::active()
            ->where('email', $email)
            ->first();
    }

    public static function userActiveExistsByEmail(?string $email): bool
    {
        if (is_null($email)) {
            return false;
        }
        return User::active()->where('email', $email)->exists();
    }
}
