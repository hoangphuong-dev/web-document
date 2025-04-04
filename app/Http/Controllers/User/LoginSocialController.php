<?php

namespace App\Http\Controllers\User;

use App\Enums\ActiveStatus;
use Google\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\AuthService;
use App\Services\User\SocialDataService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LoginSocialController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider): JsonResponse|RedirectResponse
    {
        $socialUser = AuthService::getSocialUser($request, $provider);

        if (!($socialUser['email_verified'] ?? true)) {
            notify("Tài khoản {$provider} của bạn chưa được xác thực bởi {$provider}");
            return redirect()->to(current_url());
        }
        unset($socialUser['email_verified']);

        if (Auth::guest()) {
            $this->handleLogin($provider, $socialUser);
        } else {
            // $this->handleConnect($provider, $socialUser);
        }
        return redirect()->to(current_url());
    }

    private function handleLogin(string $provider, array $socialUser): RedirectResponse
    {
        $providerId    = Arr::get($socialUser, 'id');
        $providerEmail = Arr::get($socialUser, 'email');
        $providerName  = Arr::get($socialUser, 'name');
        $socialLogin   = AuthService::getSocialLogin($provider, $providerId);

        // Trường hợp đã từng liên kết
        if ($socialLogin) {
            $user = $socialLogin?->user;
            $user = $user?->active ? $user : null;
            if ($user) {
                SocialDataService::checkUpdateSocialData($socialLogin, $socialUser);
                // Login
                Auth::guard(config('fortify.guard'))->login($user);
                goto END;
            }
        }

        // Các trường hợp chưa từng liên kết
        if ($user = UserService::getUserByEmail($providerEmail)) { // mail provider đã tồn tại trong bảng users
            if ($user->active->isNot(ActiveStatus::ACTIVE())) {
                notify("Tài khoản của bạn hiện đang khóa !");
                goto END;
            }

            // Kiểm tra user đã có liên kết với provider cùng loại chưa
            if ($user->socialLogins->where('provider', $provider)->first()) {
                notify("Tài khoản {$provider} ({$providerEmail}) đã được liên kết với một tài khoản khác.");
                goto END;
            }

            // Tạo liên kết
            AuthService::createLoginSocial($user, $provider, $socialUser);
            //Login
            Auth::guard(config('fortify.guard'))->login($user);

            goto END;
        }

        // Tạo mới tài khoản
        $user = AuthService::createNewUser([
            'full_name'         => $providerName,
            'email'             => $providerEmail ?? null,
            'email_verified_at' => $providerEmail ? time() : null,
        ]);

        // Tạo liên kết
        AuthService::createLoginSocial($user, $provider, $socialUser);

        // Login
        Auth::guard(config('fortify.guard'))->login($user);

        END:
        return redirect()->to(current_url());
    }
}
