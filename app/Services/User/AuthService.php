<?php

namespace App\Services\User;

use Google\Client;
use App\Models\User;
use Illuminate\Support\Arr;
use App\Enums\ActiveStatus;
use App\Enums\User\ConnectStatus;
use App\Models\SocialConnectHistory;
use App\Models\SocialLogin;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;

class AuthService
{
    /**
     * Tạo mới user đăng ký
     */
    public static function createNewUser(array $input): User
    {
        return User::create([
            'full_name' => mb_substr($input['full_name'], 0, 100, 'UTF-8'),
            'email'     => $input['email'],
            'password'  => isset($input['password']) ? Hash::make($input['password']) : null,
            'phone'     => $input['phone_number'] ?? '',
            'active'    => ActiveStatus::ACTIVE,

            'email_verified_at' => $input['email_verified_at'] ?? null,
        ]);
    }

    /**
     * Đăng nhập thường (email/pass)
     */
    public static function login(
        string $username,
        string $password,
        bool $remember = false,
        $callback = null
    ): mixed {
        $request = new Request();
        $request->merge([
            'username' => $username,
            'password' => $password,
            'remember' => $remember,
        ]);

        $callback = $callback ?: function () {
            return to_route('index');
        };

        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        return (new Pipeline(app()))->send($request)->through(
            array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ])
        )
            ->then($callback);
    }

    /**
     * Lấy thông tin từ social trả về
     */
    public static function getSocialUser(Request $request, string $provider): array
    {
        if ($request->isMethod('POST')) {
            $client                    = new Client([
                'client_id' => config("services.google.client_id"),
            ]);
            $socialUser                = $client->verifyIdToken($request->get("credential"));
            $_return['id']             = Arr::get($socialUser, 'sub', '');
            $_return['email']          = Arr::get($socialUser, 'email', '');
            $_return['name']           = Arr::get($socialUser, 'name', '');
            $_return['avatar']         = Arr::get($socialUser, 'picture', '');
            $_return['email_verified'] = Arr::get($socialUser, 'email_verified', '');
        } else {
            $providerClient            = Socialite::driver($provider);
            $socialUser                = $providerClient->stateless()->user();
            $_return['id']             = $socialUser->getId();
            $_return['email']          = $socialUser->getEmail();
            $_return['name']           = $socialUser->getName();
            $_return['avatar']         = $socialUser->getAvatar();
            $_return['email_verified'] = Arr::get($socialUser->user, 'email_verified', true);
        }

        return $_return;
    }

    /**
     * Lấy liên kết social trong DB
     */
    public static function getSocialLogin(string $provider, int|string $providerId, int $userId = null)
    {
        return SocialLogin::query()
            ->when(!empty($userId), function ($q) use ($userId) {
                return $q->where('user_id', $userId);
            })
            ->where([
                ['provider', $provider],
                ['provider_id', $providerId],
            ])->first();
    }

    /**
     * Tạo mới liên kết mạng xã hội
     */
    public static function createLoginSocial(User $user, string $provider, array $socialUser): void
    {
        $providerId = Arr::get($socialUser, 'id');
        try {
            // Tạo liên kết
            $user->socialLogins()->updateOrCreate(['provider' => $provider], ['provider_id' => $providerId]);

            // Ghi lịch sử liên kết
            SocialConnectHistory::create([
                'provider'     => $provider,
                'provider_id'  => $providerId,
                'user_id'      => $user->id,
                'type_connect' => ConnectStatus::CONNECT,
            ]);

            // Tạo data social
            $socialLogin = AuthService::getSocialLogin($provider, $providerId, $user->id);
            SocialDataService::checkUpdateSocialData($socialLogin, $socialUser);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }
            Log::error(format_log_message($e));
        }
    }
}
