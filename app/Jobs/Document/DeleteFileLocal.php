<?php

namespace App\Jobs\Document;

use App\Enums\Common\QueueType;
use App\Models\Document;
use App\Services\Document\DocumentService;
use App\Services\Storage\DiskPathService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteFileLocal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Document $document,
        public string $type = ''
    ) {
        $this->onQueue(QueueType::SYSTEM);
    }

    public function deleteThumbnail()
    {
        $document = $this->document;
        foreach (['M', 'L', ''] as $file) {
            $file_name = ext_change($document->file_name, 'jpg');
            $file_name = empty($file) ? $file_name : "{$file}_{$file_name}";
            if (Storage::disk('thumbnail')->exists($file_name)) {
                if (DiskPathService::storeThumbnail($file_name, Storage::disk('thumbnail')->get($file_name))) {
                    Storage::disk('thumbnail')->delete($file_name);
                    dump("Delete file thumbnail #{$document->id}");
                    Log::info("Delete file thumbnail #{$document->id}");
                }
            }
        }
    }

    public function deleteOriginal()
    {
        $document = $this->document;
        $filePath = "{$document->path}/{$document->file_name}";
        if (DiskPathService::storeDocument($filePath, Storage::disk('original')->get($filePath))) {
            Storage::disk('original')->delete($filePath);
            dump("Delete file origin #{$document->id}");
            Log::info("Delete file origin #{$document->id}");
        }
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        return match ($this->type) {
            'thumbnail' => $this->deleteThumbnail(),
            'original'  => $this->deleteOriginal(),
            default     => null,
        };
    }
}
