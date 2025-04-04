<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $e) {
            return false;
        });
        $exceptions->report(function (\App\Exceptions\Api\ValidateFailedException $e) {
            return false;
        });
        $exceptions->render(function (\App\Exceptions\Api\ValidateFailedException $e) {
            return response($e->__toString(), $e->getCode(), ['Content-Type' => 'application/json']);
        });

        // $exceptions->render(function ($request, Throwable $e) {
        //     $uriDontReport = [
        // 'broadcasting/auth',
        //     ];
        //     $dontReport = [
        // \Illuminate\Auth\Access\AuthorizationException::class,
        //     ];
        //     $checkWriteLog = (!\Illuminate\Support\Arr::first($uriDontReport, fn($uri) => $uri == trim($request->getRequestUri(), '/'))
        //         && !\Illuminate\Support\Arr::first($dontReport, fn($type) => $e instanceof $type))
        //         && (!$e instanceof \Symfony\Component\HttpKernel\Exception\HttpException || $e->getStatusCode() != 410);

        //     if ($checkWriteLog) {
        //         \Illuminate\Support\Facades\Log::channel(make_channel_log('exception'))->error(format_log_message($e));
        //     }
        //     return null;
        // });
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware toàn cục
        $middleware->append([
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            // Custom middleware
            // \BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware::class,
        ]);

        // Middleware nhóm web
        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Custom middleware
            \App\Http\Middleware\CheckUserActive::class,
            \App\Http\Middleware\LogCurrentUrlMiddleware::class,
            \App\Http\Middleware\ObfuscateClassMiddleware::class,
            \App\Http\Middleware\MinifyHtml::class, // ! Luôn đặt cuối của các Middleware !!!!
        ]);

        // Middleware nhóm API
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth'             => \App\Http\Middleware\Authenticate::class,
            'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session'     => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can'              => \Illuminate\Auth\Middleware\Authorize::class,
            'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'precognitive'     => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            'signed'           => \App\Http\Middleware\ValidateSignature::class,
            'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            // customer
            'xss'             => \App\Http\Middleware\XssSanitizerUrl::class,
            // 'obfuscate-class' => \App\Http\Middleware\ObfuscateClassMiddleware::class,
            'cacheResponse'   => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'verify-slug'     => \App\Http\Middleware\VerifySlug::class,
        ]);
    })

    // Đăng ký routes
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware('web')->group(base_path('routes/sitemaps.php'));
            Route::prefix('webhooks')->name('webhooks.')->group(base_path('routes/webhooks.php'));

            // Health check route
            // Route::get('/up')->name('health');
        },
    )
    ->create();
