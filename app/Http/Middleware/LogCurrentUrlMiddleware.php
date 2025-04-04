<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Livewire\LivewireManager;

class LogCurrentUrlMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isLivewireRequest()) {
            return $next($request);
        }

        if ($this->isMethodNotSupported($request)) {
            return $next($request);
        }

        session()->put('web_current_url', $request->fullUrl());

        return $next($request);
    }

    protected function isLivewireRequest(): bool
    {
        return class_exists(LivewireManager::class) && app(LivewireManager::class)->isLivewireRequest();
    }

    protected function isMethodNotSupported(Request $request): bool
    {
        return $request->method() != 'GET';
    }
}
