<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitizerUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$acceptParams): Response
    {
        $ignoreParams = $this->isValidQueryParam($request, $acceptParams);

        $acceptQuery  = $request->only($acceptParams);
        array_walk_recursive($acceptQuery, function (&$acceptQuery) {
            $acceptQuery = strip_tags($acceptQuery);
        });

        $request->merge($acceptQuery);

        if (!empty($ignoreParams) && $request->method() == 'GET') {
            $newUri = $request->fullUrlWithoutQuery($ignoreParams);
            return redirect()->to($newUri);
        }

        return $next($request);
    }

    private function isValidQueryParam(Request $request, array $acceptParams): array
    {
        $queryParam = array_keys($request->all());
        return array_diff($queryParam, $acceptParams);
    }
}
