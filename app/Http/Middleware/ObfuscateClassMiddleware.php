<?php

namespace App\Http\Middleware;

use Closure;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ObfuscateClassMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($this->isHtmlResponse($response) && config('view.vite_obfuscate')) {
            $content = $response->getContent();
            $updatedContent = $this->obfuscateHtmlClasses($content);
            $response->setContent($updatedContent);
        }
        return $response;
    }

    /**
     * @param string $html
     * @return string
     */
    private function obfuscateHtmlClasses(string $html): string
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath       = new DOMXPath($dom);
        $elements    = $xpath->query('//*[@class]');
        $classEncode = config('obfuscate-class', []);
        throw_if(empty($classEncode), 'Configuration for class obfuscation is empty or missing!');
        foreach ($elements as $element) {
            $classAttr = $element->getAttribute('class');
            $newClass = strtr($classAttr, $classEncode);
            $element->setAttribute('class', $newClass);
        }

        libxml_clear_errors();
        
        return html_entity_decode($dom->saveHTML(), ENT_QUOTES, 'UTF-8');
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
