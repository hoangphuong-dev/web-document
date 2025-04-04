<?php

namespace App\Http\Controllers\Sitemap;

use App\Sitemap\SitemapHelper;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        // $list    = ['categories', 'documents'];
        $list    = ['documents'];
        $sitemap = (new SitemapHelper())->list($list);
        return response($sitemap, 200, ['Content-Type' => 'application/xml']);
    }

    public function single($type)
    {
        if (!in_array($type, ['documents'])) {
            abort(404);
        }
        $sitemap = (new SitemapHelper())->list($type);
        return response($sitemap, 200, ['Content-Type' => 'application/xml']);
    }

    public function detail($type, $part)
    {
        try {
            return response(
                (new SitemapHelper())->content($type, $part),
                200,
                ['Content-type' => 'text/xml; charset=utf-8']
            );
        } catch (FileNotFoundException $e) {
            abort(404);
        }
    }
}
