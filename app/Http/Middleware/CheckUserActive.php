<?php

namespace App\Http\Middleware;

use App\Enums\ActiveStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->active->isNot(ActiveStatus::ACTIVE)) {
            if (Auth::check()) {
                Auth::guard('web')->logout();
            }
            notify(__('Tài khoản của bạn hiện đang khóa!'));
            return redirect()->route('index');
        }

        return $next($request);
    }
}
