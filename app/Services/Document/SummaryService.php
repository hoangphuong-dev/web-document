<?php

namespace App\Services\Document;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SummaryService
{
    public static function toHtmlV1(?array $summary): string
    {
        $html = '';
        if ($summary && count($summary) > 1) {
            foreach ($summary as $index => $item) {
                $heading  = Arr::get($item, 'heading', '');
                $arr      = explode('.', $heading);
                $heading  = count($arr) == 1 ? Arr::get($arr, '0') : Arr::get($arr, '1');
                $heading  = preg_replace('/^\d+\s+(.*)$/u', '$1', $heading);
                $content  = Arr::get($item, 'content', '');
                $html    .= "<h2 style='font-size: 1rem; line-height: 1.5rem; font-weight: 700;'>" . to_roman($index + 1) . ". {$heading}</h2>";
                if (!empty($content)) {
                    $contentParse = \Illuminate\Mail\Markdown::parse($content);
                    $html .= "<div style = 'padding-left: 10px'>{$contentParse}</div>";
                }
            }
        }
        return $html;
    }

    public static function toHtml(?array $summary)
    {
        $html = '';
        foreach ($summary as $index => $item) {
            $heading  = static::detectHeading(Arr::get($item, 'heading', ''));
            $content  = \Illuminate\Mail\Markdown::parse(Arr::get($item, 'content', ''));
            $index    = to_roman($index + 1);
            $html    .= "<h2 style='font-size: 1rem; line-height: 1.5rem; font-weight: 700;'>{$index}.{$heading}</h2>";
            if ($subHeading = Arr::get($item, 'sub_heading')) {
                $content .= static::htmlSubHeading($subHeading);
            }
            $html    .= "<div style='padding-left: 10px'>{$content}</div>";
        }
        return $html;
    }

    private static function htmlSubHeading(array $subHeading)
    {
        $html = '';
        foreach ($subHeading as $item) {
            $heading     = static::removeSymbols(Arr::get($item, 'sub_head', ''));
            $subContent  = Arr::get($item, 'sub_content', '');
            $content     = empty($subContent) ? '' : \Illuminate\Mail\Markdown::parse($subContent);
            $html       .= "<h3 style='padding-left: 20px; font-weight: 700; padding-top: 10px; padding-bottom: 8px;'>{$heading}</h3>";
            $html       .= "<div style='padding-left: 30px'>{$content}</div>";
        }
        return $html;
    }

    private static function detectHeading(string $heading): string
    {
        $arr     = explode('.', $heading);
        $heading = count($arr) == 1 ? Arr::get($arr, '0') : Arr::get($arr, '1');
        if (preg_match("/^\d+/si", $heading,  $matches)) {
            $heading = Str::after($heading, $matches[0]);
        }
        return static::removeSymbols($heading);
    }

    private static function removeSymbols(string $text): string
    {
        return preg_replace('/[^\w^\d^\.^]+/uis', ' ', $text);
    }
}
