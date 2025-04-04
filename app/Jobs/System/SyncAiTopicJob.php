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

class SyncAiTopicJob implements ShouldQueue
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
        dump("Sync ai_topic #{$docId}");

        $topics    = $docMeta->document->topics;
        if ($topics->isEmpty()) {
            dump("Không có topic cho tài liệu #{$docId}");
            return;
        }
        $this->trySaveTopicsWithRetries($docMeta, $topics);
    }

    private function trySaveTopicsWithRetries(DocumentMetaData $docMeta, $topics)
    {
        $maxRetries = 5;
        $retryCount = 0;
        while ($topics->count() > 0 && $retryCount < $maxRetries) {
            $strTopics = $topics->map(fn($topic) => "{$topic->id}:{$topic->name}")->implode(',');
            try {
                $this->saveTopic($docMeta, $strTopics);
                return;
            } catch (\Illuminate\Database\QueryException $e) {
                // Lỗi dữ liệu quá dài cho cột
                if ($e->getCode() === '22001') {
                    Log::warning("Chuỗi topic quá dài cho tài liệu #{$docMeta->document_id}. Thử lại lần {$retryCount}...");
                    $topics = $topics->take($topics->count() - 1); // Cắt bỏ thêm 1 topic
                    $retryCount++;
                } else {
                    throw $e;
                }
            } catch (\Exception $ex) {
                Log::error(format_log_message($ex));
                return; // Thoát nếu gặp lỗi khác ngoài SQLSTATE[22001]
            }
        }
        Log::error("Không thể lưu ai_topic cho tài liệu #{$docMeta->document_id} sau {$maxRetries} lần thử.");
    }

    private function saveTopic(DocumentMetaData $docMeta, $str)
    {
        $docMeta->ai_topic = $str;
        $docMeta->save();
        dump("Success ai_topic #{$docMeta->document_id}");
    }
}
