<?php

namespace App\Services\Tag;

use App\Models\Document;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TagService
{
    public static function documentByTag(Tag $tag)
    {
        return Document::query()
            ->join('document_tags', 'document_id', '=', 'documents.id')
            ->public()
            ->with(['metaData', 'categories'])
            ->where('tag_id', $tag->id)
            ->simplePaginate(10);
    }

    /**
     *  Query bảng phụ => Lấy những tài liệu trùng nhiều tags với list trùng topics (>= 3tags)
     */
    public static function related(array|Collection $documentIds, int $numberCheck = 3): Collection
    {
        return DB::table('document_tags')
            ->selectRaw("document_id, count(*) as number")
            ->whereIn('document_id', $documentIds)
            ->groupBy('document_id')
            ->having('number', '>', $numberCheck)
            ->orderBy('number')
            ->limit(20)
            ->get();
    }

    public static function makeTagDocument(Document $document, array $tagNames): array
    {
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            if (check_word_count($tagName, 3, 10)) { // 3-10 từ
                $tag      = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }
        $document->tags()->sync($tagIds);
        return $document->tags->pluck('name')->toArray();
    }
}
