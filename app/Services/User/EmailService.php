<?php

namespace App\Services\User;

use App\Enums\Common\QueueType;
use App\Mail\ResetPasswordEmail;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public static $queue = QueueType::EMAIL;

    public static function sendDownloadOneTime(string $email, Document $document) {}

    public static function sendEmailResetPassword(User $user, string $token)
    {
        $email = $user->email;
        return Mail::to($email)->queue(
            (new ResetPasswordEmail($user, $token))->onQueue(static::$queue)
        );
    }

    public static function sendEmailVerification(User $user)
    {
        $email = $user->email;
        return Mail::to($email)->queue(
            (new VerifyEmail($user))->onQueue(static::$queue)
        );
    }
}
