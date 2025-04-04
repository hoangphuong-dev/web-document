<?php

namespace App\Console\Commands\Sitemap;

use App\Helpers\URLGenerate;
use App\Models\Document;
use Illuminate\Console\Command;
use App\Services\Storage\DiskPathService;
use App\Sitemap\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DocumentSitemap extends Command
{
    use IncrementSitemap;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:documents
     {--clean : clean old file}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gen sitemap for documents page';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = Document::query()->public();

        $this->disk = DiskPathService::sitemap();
        $name = "documents";
        $max_images = config('sitemap.documents.max_images');
        // https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap?hl=vi#general-guidelines
        //* Max 50K link
        $length = $max_images ? 10000 : 15000;

        if ($this->option('clean')) {
            $this->cleanOld($name, "sitemap");
        }
        $current_urls = $this->sitemap_helper->getTotalUrl($name);
        $chunk = config('sitemap.documents.chunk');
        $max = max($current_urls, config('sitemap.documents.min_sitemap')) + rand((int)($chunk / 2), $chunk);
        $this->info("Making sitemap for about " . $max . " urls (" . $current_urls . ")");
        $progressbar = $this->getOutput()->createProgressBar($max);
        $progressbar->display();
        $this->makeSitemap($query, $name, $length, 100, $max, $progressbar);
        $progressbar->finish();
        return Command::SUCCESS;
    }

    protected function makeUrl(Document $document): string|Url
    {
        if (!$this->shouldInjectToSitemap($document)) {
            return false;
        }
        $url            = URLGenerate::urlDocumentDetail($document);
        $modified       = Carbon::make($document->updated_at)->format('Y-m-d\TH:i:sP');
        // $image[]['loc'] = $document->urlThumbnail();
        $image = [];
        return new Url($url, $modified, $image);
    }

    protected function shouldInjectToSitemap(Document $document): bool
    {
        if (!$document->slug) {
            Log::error("No slug document " . $document->id);
            return false;
        }
        return true;
    }
}
