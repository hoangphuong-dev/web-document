<?php

namespace App\Services\Document;

use App\Models\Document;
use Helpers\Formatter;
use Helpers\KeywordLibrary;
use Illuminate\Support\Arr;

class TitleService
{
    public static function bestTitle(string $title, string $filename = ''): string
    {
        //TODO: choose the best title
        $title = empty($title) ? $filename : $title;
        $title = KeywordLibrary::standardTitle($title);
        return $title;
    }

    public static function shortTitle(Document $document)
    {
        $arrTitle = explode(' ', $document->title);
        $result   = array_combine(
            array_map(fn($word) => strtolower(Formatter::removeAccent($word)), $arrTitle),
            $arrTitle
        );
        $arrSlug    = explode('-', $document->slug);
        $arrShort   = Arr::only($result, $arrSlug);
        $titleShort = implode(' ', $arrShort);
        return KeywordLibrary::standardTitle($titleShort);
    }
}
