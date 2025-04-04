<?php

namespace App\Services\Cache;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;
use Livewire\LivewireManager;
use Illuminate\Support\Facades\App;

class CacheAllSuccessfulGetRequests extends BaseCacheProfile
{
    public function enabled(Request $request): bool
    {
        return config('responsecache.enabled') && !Auth::check() && App::environment(['production']);
    }

    public function useCacheNameSuffix(Request $request): string
    {
        return is_mobile_site() ? 'guest_mobile' : 'guest_desktop';
    }

    public function shouldCacheRequest(Request $request): bool
    {
        if ($request->ajax() || $this->isRunningInConsole() || $this->isLivewireRequest()) {
            return false;
        }

        return $request->isMethod('get') && !Auth::check();
    }

    protected function isLivewireRequest(): bool
    {
        return class_exists(LivewireManager::class) && app(LivewireManager::class)->isLivewireRequest();
    }

    public function shouldCacheResponse(Response $response): bool
    {
        if (!$this->hasCacheableResponseCode($response)) {
            return false;
        }

        if (!$this->hasCacheableContentType($response)) {
            return false;
        }

        return true;
    }

    public function hasCacheableResponseCode(Response $response): bool
    {
        if ($response->isSuccessful()) {
            return true;
        }

        if ($response->isRedirection()) {
            return true;
        }

        return false;
    }

    public function hasCacheableContentType(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type', '');

        if (str_starts_with($contentType, 'text/')) {
            return true;
        }

        if (Str::contains($contentType, ['/json', '+json'])) {
            return true;
        }

        return false;
    }
}
