<?php

namespace App\Console\Commands\Sitemap;

use App\Helpers\URLGenerate;
use App\Models\Category;
use App\Services\Storage\DiskPathService;
use App\Sitemap\Url;
use Illuminate\Console\Command;

class CategorySitemap extends Command
{
    use IncrementSitemap;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:categories {--clean}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sitemap list post by category';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd('Chưa public sitemap này !! vì có nhiều cat trống.');
        $query = Category::select(['id', 'name', 'updated_at']);
        $this->disk = DiskPathService::sitemap();
        $name = "categories";
        $max_images = config('sitemap.categories.max_images');
        $length = $max_images ? 15000 : 20000;
        if ($this->option('clean')) {
            $this->cleanOld($name, "sitemap");
        }
        $current_urls = $this->sitemap_helper->getTotalUrl($name);

        $chunk = config('sitemap.categories.chunk');
        $max = max($current_urls, config('sitemap.categories.min_sitemap')) + rand((int)($chunk / 2), $chunk);
        $this->info("Making sitemap for about " . $max . " urls (" . $current_urls . ")");
        $progressbar = $this->getOutput()->createProgressBar($max);
        $progressbar->display();
        $this->makeSitemap($query, $name, $length, 100, $max, $progressbar);
        $progressbar->finish();
        return Command::SUCCESS;
    }

    /**
     * @param Category $category
     * @return string|Url
     */
    protected function makeUrl($category): string|Url
    {
        $url = route('category.index', ['slug' => $category->slug]);
        $url = URLGenerate::urlCat($category);
        $modified = $category->updated_at->format('Y-m-d\TH:i:sP');
        return new Url($url, $modified);
    }
}
