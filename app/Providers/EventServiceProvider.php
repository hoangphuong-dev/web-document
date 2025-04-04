<?php

namespace App\Providers;

use App\Listeners\User\EmailVerificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Đăng ký tài khoản thành công 
        Registered::class => [
            // EmailVerificationListener::class,
        ],

        // Xác thực email thành công
        Verified::class => [
            // todo: setup notify user by popup
            // NotifyVerified::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
