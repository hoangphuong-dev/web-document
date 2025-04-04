<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use App\Services\User\EmailService;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property text $two_factor_secret
 * @property text $two_factor_recovery_codes
 * @property Carbon $two_factor_confirmed_at
 * @property string $phone
 * @property string $address
 * @property int $type
 * @property string $avatar
 * @property int $active
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    // use HasApiTokens;
    use HasFactory, Notifiable, SoftDeletes;

    public    $primaryKey        = 'id';
    protected $table             = 'users';
    protected $guarded           = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'active'            => ActiveStatus::class,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', ActiveStatus::ACTIVE);
    }

    /*
    |--------------------------------------------------------------------------
    | Custom reset password
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token): void
    {
        EmailService::sendEmailResetPassword($this, $token);
    }

    public function resetUrl($token): string
    {
        return url(route('password.reset', [
            'token' => $token,
            'email' => $this->email,
        ], false));
    }

    /*
    |--------------------------------------------------------------------------
    | Custom email verification
    |--------------------------------------------------------------------------
    */

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'active'            => ActiveStatus::ACTIVE,
        ])->save();
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    public function verificationUrl(): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addSeconds(config('auth.verification.expire', 1800)),
            [
                'id'   => $this->getKey(),
                'hash' => sha1($this->email),
            ]
        );
    }

    /**
     * Liên kết mạng xã hội
     *
     * @return HasMany
     */
    public function socialLogins(): HasMany
    {
        return $this->hasMany(SocialLogin::class, 'user_id', 'id');
    }

    /**
     * Kiểm tra user có phải là admin hay không ?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return true;
        return $this->email == 'hoangphuong.work02@gmail.com';
    }
}
