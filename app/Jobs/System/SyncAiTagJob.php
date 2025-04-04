<?php

namespace App\Jobs\System;

use App\Enums\Common\QueueType;
use App\Models\DocumentMetaData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncAiTagJob implements ShouldQueue
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
        $docMeta = $this->docMeta;
        $docId   = $docMeta->document_id;
        dump("Sync ai_tag #{$docId}");

        $tags = $docMeta->document->tags;
        if ($tags->isEmpty()) {
            dump("Không có tags cho tài liệu #{$docId}");
            return;
        }
        $this->trySaveTagsWithRetries($docMeta, $tags);
    }

    private function trySaveTagsWithRetries(DocumentMetaData $docMeta, $tags)
    {
        $maxRetries = 5; // Số lần thử tối đa
        $retryCount = 0;
        while ($tags->count() > 0 && $retryCount < $maxRetries) {
            $strTags = $tags->map(fn($tag) => "{$tag->id}:{$tag->name}")->implode(',');
            try {
                $this->saveTag($docMeta, $strTags);
                return; // Thành công thì thoát khỏi vòng lặp
            } catch (\Illuminate\Database\QueryException $e) {
                // Lỗi dữ liệu quá dài cho cột
                if ($e->getCode() === '22001') {
                    Log::warning("Chuỗi tag quá dài cho tài liệu #{$docMeta->document_id}. Thử lại lần {$retryCount}...");
                    $tags = $tags->take($tags->count() - 1); // Cắt bỏ thêm 1 tag
                    $retryCount++;
                } else {
                    throw $e; // Nếu là lỗi khác, ném lại ngoại lệ
                }
            } catch (\Exception $ex) {
                Log::error(format_log_message($ex));
                return; // Thoát nếu gặp lỗi khác ngoài SQLSTATE[22001]
            }
        }
        Log::error("Không thể lưu ai_tag cho tài liệu #{$docMeta->document_id} sau {$maxRetries} lần thử.");
    }

    private function saveTag(DocumentMetaData $docMeta, $str)
    {
        $docMeta->ai_tag = $str;
        $docMeta->save();
        dump("Success ai_tag #{$docMeta->document_id}");
    }
}
