<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->isHtmlResponse($response)) {
            $output = $response->getContent();

            // Minify the HTML output
            $output = $this->minify($output);

            $response->setContent($output);
        }
        return $response;
    }

    /**
     * @param string $html
     *
     * @return string
     */
    protected function minify(string $html): string
    {
        $htmlFilters = [
            // Loại bỏ các bình luận HTML, ngoại trừ các bình luận điều kiện
            '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',
            // Loại bỏ các bình luận một dòng (/ /)
            '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|(?<!\S)\/\/\s*[^\r\n]*/' => '',
            // Rút ngắn các khoảng trắng nhiều lần
            '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|\s{2,}/' => ' ',
            // Loại bỏ khoảng trắng giữa các thẻ HTML
            '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|>\s{2,}</' => '><',
            // Thu gọn các dòng mới
            '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|(\r?\n)/' => '',
        ];
        $output = preg_replace(array_keys($htmlFilters), array_values($htmlFilters), $html);
        return $output ?? $html;
    }

    /**
     * Determine if the response is HTML.
     *
     * @param  mixed  $response
     * @return bool
     */
    protected function isHtmlResponse(mixed $response): bool
    {
        return $response instanceof Response && str_contains($response->headers->get('Content-Type'), 'text/html');
    }
}
