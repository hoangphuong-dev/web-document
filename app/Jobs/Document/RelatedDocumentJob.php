<?php

namespace App\Jobs\Document;

use App\Enums\Common\QueueType;
use App\Models\Document;
use App\Models\DocumentMetaData;
use App\Services\Tag\TagService;
use App\Services\Topic\TopicService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class RelatedDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public DocumentMetaData $docMeta)
    {
        $this->onQueue(QueueType::SYSTEM);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dump("Updating document #{$this->docMeta->document_id}");

        // Lấy danh sách document liên quan từ topic
        $documentTopic = TopicService::related($this->docMeta->document);

        // Nếu có hơn 5 document, lấy thêm thông tin từ TagService
        $documentTag = $documentTopic->count() > 5
            ? TagService::related($documentTopic->pluck('document_id'))
            : $documentTopic;

        // Lấy danh sách document_id từ ai_topical
        $documentInTopical = $this->documentFromTopical($this->docMeta->ai_topical);

        // Lọc ra ID không thuộc documentInTopical và chỉ lấy tối đa 15 phần tử
        $resultIds = $documentTag->pluck('document_id')->diff($documentInTopical)->take(15);

        if ($resultIds->isNotEmpty()) {
            $this->docMeta->update([
                'list_related_id'   => $resultIds->implode(','),
                'list_related_time' => Carbon::now(),
            ]);
            dump('Update success document related !!!!');
        } else {
            $this->docMeta->update(['list_related_time' => Carbon::now()]);
            dump("NOT RELATED #{$this->docMeta->document_id}");
        }
    }

    /**
     * Lấy danh sách document_id từ ai_topical
     */
    private function documentFromTopical(string $topical): Collection
    {
        preg_match_all('/https?:\/\/[^\/]+\/document\/([^\/]+)/i', $topical, $matches);
        return empty(Arr::last($matches)) ? collect() : Document::whereIn('slug', Arr::last($matches))->pluck('id');
    }
}
