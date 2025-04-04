<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Helpers\Formatter;
use App\Services\User\UserService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request): RedirectResponse
            {
                // action logout , delete cookie
                return redirect()->back(302, [], route('index'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . get_user_ip_address());

            return Limit::perMinute(6)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(6)->by($request->session()->get('login.id'));
        });

        /**
         * Customizing user authentication
         */
        Fortify::authenticateUsing(function (Request $request) {
            $username = Formatter::removeQuotes($request->input('username', ''));
            if ($user = UserService::getUserActiveByEmail($username)) {
                $password = $request->input('password', '');
                if (Hash::check($password, $user->password)) {
                    return $user;
                }
            }
            return null;
        });

        /**
         * Custom reset password
         */
        Fortify::resetPasswordView(function (Request $request) {
            // SEOMeta::setTitle('Đặt lại mật khẩu');
            return view('auth.reset-password', ['request' => $request]);
        });

        /**
         * Custom email verification
         */
        Fortify::verifyEmailView(function (Request $request) {
            // SEOMeta::setTitle('Xác thực email');
            return view('auth.email-verify', ['request' => $request]);
        });

        /**
         * Custom login page
         */
        Fortify::loginView(function (Request $request) {
            return redirect()->route('index');
        });
    }
}
