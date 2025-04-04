<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seo\CategoryController;
use App\Http\Controllers\Seo\TagController;
use App\Http\Controllers\Seo\TopicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Document\SearchController;

/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

Route::get('', [HomeController::class, 'index'])
    ->middleware(['xss:page'])
    ->name('index');

Route::get('/tim-kiem', [SearchController::class, 'searchDocument'])
    ->middleware([
        'xss:keyword,page,ext,length,sort,category,advanced'
    ])->name('search-document');


Route::middleware(['verify-slug'])->group(function () {
    Route::get('danh-muc/{slug?}.c{category}', [CategoryController::class, 'index'])
        ->middleware(['xss:page,cursor', 'cacheResponse:2592000']) // cache 1 tháng
        ->name('category.index');

    Route::get('tag/{slug?}.t{tag}', [TagController::class, 'index'])
        ->middleware(['xss:page,cursor', 'cacheResponse:2592000']) // cache 1 tháng
        ->name('tag.index');

    Route::get('chu-de/{slug?}.t{topic}', [TopicController::class, 'index'])
        ->middleware(['xss:page,cursor', 'cacheResponse:2592000']) // cache 1 tháng

        ->name('topic.index');
});
