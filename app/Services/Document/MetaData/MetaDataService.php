<?php

namespace App\Services\Document\MetaData;

use App\Models\DocumentMetaData;

class MetaDataService
{
    public static function updateTimeDocument(DocumentMetaData $docMeta): void
    {
        $docMeta->document->updated_at = now();
        $docMeta->document->save();
    }

    public static function topicalToHtml(?string $topicalMarkdown = '')
    {
        if (!empty($topicalMarkdown) && strpos(\Illuminate\Mail\Markdown::parse($topicalMarkdown), '<a') !== false) {
            $html = \Illuminate\Mail\Markdown::parse($topicalMarkdown);
            return preg_replace_callback('#https?://[^\s<>"\'()]+#', fn($matches) => preg_replace('#\\\\/#', '/', $matches[0]), $html);
        }
        return '';
    }
}
