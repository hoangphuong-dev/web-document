<?php

namespace App\Console\Commands\System;

use App\Jobs\System\SyncAiTagJob;
use App\Models\DocumentMetaData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncAiTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vn:sync-ai-tag
    {--document_id= : Document id}
    {--limit= : limit}
    {--f|force : Force}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lấy dữ liệu từ relations n-n => cập nhật ai_tag trong document_meta_data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        $force      = $this->option('force');
        $documentId = $this->option('document_id');
        $limit      = $this->option('limit');

        DocumentMetaData::query()
            ->when($documentId, function ($query) use ($documentId) {
                return $query->where('document_id', $documentId);
            })
            ->when(!$force, function ($query) {
                return $query->whereNull('ai_tag');
            })
            ->limit($limit)
            ->lazyById(100)->each(function ($docMetaData) use ($force) {
                $this->comment("Process SyncAiTagJob #{$docMetaData->document_id}");
                $force ? (new SyncAiTagJob($docMetaData))->handle(): SyncAiTagJob::dispatch($docMetaData);
            });

        return static::SUCCESS;
    }
}
