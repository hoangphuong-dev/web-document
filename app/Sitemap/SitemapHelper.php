<?php


namespace App\Sitemap;

use App\Services\Storage\DiskPathService;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use League\Flysystem\FileAttributes;

class SitemapHelper
{
    /**
     * @param $types
     *
     */
    public function list($types)
    {
        $types = Arr::wrap($types);
        $sitemap = new SitemapSet();
        foreach ($types as $type) {
            $files = DiskPathService::sitemap()->listContents($this->rootPath($type));
            /** @var FileAttributes $file */
            foreach ($files as $file) {
                $file_name = basename($file->path(), '.xml');
                $a_name = explode('_', $file_name, 2);
                $url = route('sitemap.detail', ['type' => $type, 'part' => $a_name[1]]);
                $last_modify = Carbon::parse($file->lastModified())->format('Y-m-d\TH:i:s+00:00');
                $url = new SitemapUrl($url, $last_modify);
                $sitemap->addUrl($url);
            }
        }
        return $sitemap->content();
    }

    /**
     * @param $type
     * @param $path
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function content($type, $path)
    {
        $file_path = $this->filePath($type, $path);
        return DiskPathService::sitemap()->get($file_path);
    }

    /**
     * @param null $type
     *
     * @return string
     */
    private function rootPath($type = null)
    {
        return $type;
    }

    /**
     * @param $type
     * @param $part
     *
     * @return string
     */
    private function filePath($type, $part)
    {
        return $this->rootPath($type) . DIRECTORY_SEPARATOR . $type . "_" . $part . '.xml';
    }

    public function getSitemapInfo($disk, $path): SitemapInfo
    {
        $sitemap_info =  new SitemapInfo(disk: $disk, path: $path);
        try {
            $last_mod = \Storage::disk($disk)->lastModified($path);
            $content = \Storage::disk($disk)->read($path);
        } catch (\Exception $ex) {
            return $sitemap_info;
        }
        $sitemap_info->size = strlen($content);
        $sitemap_info->hash = md5($content);
        $sitemap_info->last_mod = Carbon::createFromTimestamp($last_mod);
        $sitemap_info->urls = substr_count($content, "<loc>");
        return $sitemap_info;
    }

    public function getTotalUrl($sitemap_name): int
    {
        $files = DiskPathService::sitemap()->listContents($sitemap_name);
        $total = 0;
        /** @var FileAttributes $file */
        foreach ($files as $file) {
            if (!preg_match("/" . $sitemap_name . "\_\d+\.xml$/ui", $file->path())) continue;
            $sitemap_info = $this->getSitemapInfo('sitemap', $file->path());
            $total += $sitemap_info->urls;
        }
        return $total;
    }
}
