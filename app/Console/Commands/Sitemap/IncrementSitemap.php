<?php

namespace App\Console\Commands\Sitemap;

use App\Sitemap\SitemapHelper;
use App\Sitemap\Url;
use App\Sitemap\UrlSet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\FileAttributes;
use Log;
use Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

trait IncrementSitemap
{
    protected ?FilesystemAdapter $disk = null;
    protected SitemapHelper $sitemap_helper;

    public function __construct()
    {
        parent::__construct();
        $this->sitemap_helper = new SitemapHelper();
    }

    protected function makeSitemap(Builder $query, $name, $length = 20000, $chunk = 100, $max = PHP_INT_MAX, ProgressBar $progressBar = null)
    {
        $min_id = 1;
        $part = 1;

        if ($this->disk) {
            $root = $name;
        } else {
            $root = storage_path("app/sitemaps/" . $name);
        }

        $url_set = new UrlSet($root . "/" . $name . "_" . $part . ".xml", $this->disk);
        $count = 0;
        $total = 0;

        $query->where('id', '>=', $min_id)->chunkById(
            $chunk,
            function ($contents) use (&$url_set, $length, $root, &$count, &$part, &$total, $max, $name, $progressBar) {
                $urls = [];
                foreach ($contents as $content) {
                    $url = $this->makeUrl($content);
                    if (!$url) {
                        continue;
                    }
                    $count++;
                    $total++;
                    if ($url instanceof Url) {
                        $urls[] = $url;
                    } else {
                        $urls[] = new Url($url, $content->updated_at->format('Y-m-d\TH:i:sP'));
                    }

                    if ($count >= $length) {
                        $count = 0;
                        $url_set->addUrls($urls, false);
                        $url_set->save();
                        $urls = [];
                        $this->info(" Done part " . $part);
                        $part++;
                        $url_set = new UrlSet($root . "/" . $name . "_" . $part . ".xml", $this->disk);
                    }

                    if ($total >= $max) {
                        return false;
                    }
                }
                if ($progressBar) {
                    $progressBar->setProgress($total);
                } else {
                    $this->info("Generated to " . $contents->last()->id, OutputInterface::VERBOSITY_VERBOSE);
                }
                if ($count > 0) {
                    $url_set->addUrls($urls, false);
                }
            }
        );

        if (!$query->first()) {
            $url = url('/');
            $url = new Url($url, now()->format('Y-m-d\TH:i:sP'));
            $url_set->addUrl($url, false);
        }
        if ($url_set->count()) {
            $url_set->save();
        }
        Log::alert("Sitemap generated for " . $name . " : " . $total);
        return 0;
    }

    protected function makeUrl($content): string|Url
    {
        return '';
    }

    /**
     * Get total published from published date to today
     * @param $chunk
     * @param $days
     * @param $start_date
     * @return int
     */
    protected function computeMax($chunk, $days, $start_date)
    {
        $start_date = $start_date ? Carbon::parse($start_date) : Carbon::now()->subDay();
        $published_days = $start_date->diffInDays(now());
        $today_published = rand(1, $chunk);
        return ((int)($published_days / $days) - 1) * $chunk + $today_published;
    }

    protected function cleanOld($root, $disk)
    {
        $files = Storage::disk($disk)->listContents('/' . $root);
        /** @var FileAttributes $file */
        foreach ($files as $file) {
            if ($file->lastModified() < now()->timestamp - 5) {
                $this->warn("Deleting " . $file->path());
                Storage::disk($disk)->delete($file->path());
            }
        }
    }
}
