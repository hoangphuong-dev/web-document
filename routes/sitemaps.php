<?php

use App\Http\Controllers\Sitemap\SitemapController;
use Illuminate\Support\Facades\Route;

Route::name('sitemap.')
    ->group(function () {
        Route::get('/sitemaps.xml', [SitemapController::class, 'index'])->name('all');
        Route::get('/sitemaps/{type}.xml', [SitemapController::class, 'single'])->name('single');
        Route::get('/sitemap/{type}_{part}.xml', [SitemapController::class, 'detail'])->name('detail');
    });
