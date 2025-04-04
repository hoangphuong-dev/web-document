<?php

namespace App\Jobs\System;

use App\Enums\Common\QueueType;
use App\Services\Document\DocumentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheDataPageHomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue(QueueType::SYSTEM);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $time = 172800; // cache 2 ngày

        // Tài liệu mới nhất
        Log::info('Caching data latest_document');
        dump('Caching data latest_document');
        Cache::driver('database')->put('latest_document', DocumentService::getNewDocument(), $time);

        // Tài liệu tải nhiều
        Log::info('Caching data multiple_download_document');
        dump('Caching data multiple_download_document');
        Cache::driver('database')->put('multiple_download_document', DocumentService::getMultiDownloadDoc(), $time);

        // Tài liệu xem nhiều
        Log::info('Caching data most_view_document');
        dump('Caching data most_view_document');
        Cache::driver('database')->put('most_view_document', DocumentService::getMostViewDoc(), $time);
    }
}
