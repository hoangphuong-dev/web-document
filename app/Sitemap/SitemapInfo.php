<?php

namespace App\Sitemap;

use Carbon\Carbon;

class SitemapInfo
{
    public function __construct(
        public string $disk = '',
        public string $path = '',
        public int $size = 0,
        public string $hash = '',
        public ?Carbon $last_mod = null,
        public int $urls = 0,
    ) {}
}
