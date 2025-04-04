<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Minify_HTML;

class MinifyHtml
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (
            !Auth::check() && App::environment(['production']) &&
            $response->headers->get('Content-Type') === 'text/html; charset=UTF-8'
        ) {
            $options = [
                'xhtml' => true,
                'jsCleanUrls' => false,
                'cssMinifier' => null,
                'jsMinifier'  => null,
            ];

            $content = $response->getContent();
            $modifiedContent = preg_replace(
                '/(<script[^>]*src="[^"]*\/livewire\/livewire(\.min)?\.js(\?[^"]*)?"[^>]*)>/i',
                '$1 defer>',
                $content
            );

            // set defer js livewire
            $contentNew = $modifiedContent !== null ? $modifiedContent : $content;
            $html   = new Minify_HTML($contentNew, $options);
            $response->setContent($html->process());
        }
        return $response;
    }
}
