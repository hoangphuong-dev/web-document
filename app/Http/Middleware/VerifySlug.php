<?php

namespace App\Http\Middleware;

use App\Helpers\URLGenerate;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySlug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUrl = match ($request->route()->getName()) {
            'tag.index'      => URLGenerate::urlTag($request->route('tag')),
            'topic.index'    => URLGenerate::urlTopic($request->route('topic')),
            'category.index' => URLGenerate::urlCat($request->route('category')),
            default          => null,
        };

        if (isset($expectedUrl) && $expectedUrl != $request->url()) {
            return redirect($expectedUrl, 301);
        }

        return $next($request);
    }
}
