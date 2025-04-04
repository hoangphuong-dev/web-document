<?php


namespace App\Sitemap;


class SitemapSet
{
    protected $prefix = <<<PREFIX
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
PREFIX;
    protected $subfix = <<<SUBFIX
</sitemapindex>
SUBFIX;


    protected $urls = [];

    public function __construct() {

    }

    public function addUrl($url) {
        $this->urls[] = $url;
    }

    public function addUrls(array $urls = []){
        $this->urls = $this->urls + $urls;
    }

    public function content(){
        $contents = '';
        foreach ($this->urls as $url){
            $contents .= is_string($url) ?
"<sitemap>
    <loc>".$url."</loc>
</sitemap>\n" : $url;
        }
        return $this->prefix . "\n" . $contents . "\n" . $this->subfix;
    }
}
