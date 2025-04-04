<?php

namespace App\Console\Commands\Document;

use App\Jobs\Document\RelatedDocumentJob;
use App\Models\DocumentMetaData;
use Illuminate\Console\Command;

class UpdateRelatedDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vn:update-related-document
    {--document_id= : Document id}
    {--limit=50 : limit item}
    {--f|force : Force}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        DocumentMetaData::query()
            ->idRange($this->option('document_id'), 'document_id')
            ->when(!$force, fn($query) => $query->whereNull('list_related_id')->whereNull('list_related_time'))
            ->with('document')
            ->limit($this->option('limit'))->get()
            ->each(function ($item) use ($force) {
                dump("PROCESS RELATED #{$item->id}");
                $force ? (new RelatedDocumentJob($item))->handle() : RelatedDocumentJob::dispatch($item);
            });
    }
}
