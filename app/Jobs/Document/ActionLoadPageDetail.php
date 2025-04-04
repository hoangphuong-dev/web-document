<?php

namespace App\Jobs\Document;

use App\Enums\Common\QueueType;
use App\Models\Document;
use App\Services\Document\DocumentStatisticService;
use App\Services\Document\DocumentViewService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActionLoadPageDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document)
    {
        $this->onQueue(QueueType::SYSTEM);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $document = $this->document;
        // tăng lượt xem
        DocumentStatisticService::increment($document, 'number_view');
    }
}
