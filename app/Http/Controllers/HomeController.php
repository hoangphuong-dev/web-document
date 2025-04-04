<?php

namespace App\Http\Controllers;

use App\Services\Document\DocumentService;
use App\Services\SEO\SeoService;

class HomeController extends Controller
{
    public function index()
    {
        SeoService::seoTitle(config('app.name') . " - Nền tảng chia sẻ sáng kiến kinh nghiệm chuyên nghiệp.");
        SeoService::seoUrl(config('app.url'));
        SeoService::seoType();
        SeoService::seoDescription(config('seotools.meta.defaults.description'));
        SeoService::setRobots('all');

        [$latestDoc, $multipleDownloadDoc, $mosViewDoc] = DocumentService::fetchCachePageHome();
        return view('home.main', compact('latestDoc', 'multipleDownloadDoc', 'mosViewDoc'));
    }
}
