<?php

namespace App\Services\Document;

use App\Models\Document;
use App\Models\DocumentDownload;
use Illuminate\Support\Carbon;

class DocumentStatisticService
{
    public static function increment(Document $document, string $field): void
    {
        $fieldUpdate = ['number_download', 'number_view'];
        if (in_array($field, $fieldUpdate)) {
            $document->increment($field);
        }
    }

    public static function documentDownload(int $docId, int $userId)
    {
        DocumentDownload::create([
            'document_id' => $docId,
            'user_id'     => $userId,
            'time'        => Carbon::now(),
        ]);
    }
}
