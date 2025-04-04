<?php

namespace App\Providers;

use App\Models\Document;
use App\Services\Document\DocumentService;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Binding lại document khi truyền vào router
        Route::bind('document', fn($value) => $this->bindingDocument($value));

        RateLimiter::for('api', function (Request $request) {
            // todo: turn off for upload
            // return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('webhooks')
                ->name('webhooks.')
                ->group(base_path('routes/webhooks.php'));

            Route::middleware('web')
                ->group(base_path('routes/sitemaps.php'));
        });
    }


    private function bindingDocument($value)
    {
        try {
            $realId   = DocumentService::getHashHandler()->decode($value);
            $document = Document::whereId($realId)->firstOrFail() ?? Document::whereSlug(request()->route('slug'))->firstOrFail();
        } catch (\Exception $ex) {
            Log::error(format_log_message($ex));
            $document = Document::whereSlug(request()->route('slug'))->firstOrFail();
        }
        return $document;
    }
}
