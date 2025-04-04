<?php

namespace App\Services\Topic;

use App\Models\Document;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TopicService
{
    public static function documentByTopic(Topic $topic)
    {
        return Document::query()
            ->join('document_topics', 'document_id', '=', 'documents.id')
            ->public()
            ->with(['metaData', 'categories'])
            ->where('topic_id', $topic->id)
            ->simplePaginate(10);
    }

    /**
     * Query từ bảng phụ => Lấy những tài liệu trùng nhiều topics với tài liệu gốc (>= 2tags)
     */
    public static function related(Document $document, $numberCheck = 1): Collection
    {
        return DB::table('document_topics')
            ->selectRaw("document_id, count(*) as number")
            ->whereIn('topic_id', $document->topics->pluck('id'))
            ->where('document_id', '<>', $document->id)
            ->groupBy('document_id')
            ->having('number', '>=', $numberCheck)
            ->orderBy('number')
            ->limit(20)
            ->get();
    }

    public static function makeTopicDocument(Document $document, array $topicNames): array
    {
        $topicId = [];
        foreach ($topicNames as $tagName) {
            if (check_word_count($tagName, 4, 10)) { // 4 - 10 từ
                $tag      = Topic::firstOrCreate(['name' => $tagName]);
                $topicId[] = $tag->id;
            }
        }
        $document->topics()->sync($topicId);
        return $document->topics->pluck('name')->toArray();
    }
}
