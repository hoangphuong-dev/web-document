<?php

/* Simple configuration file for Laravel Sitemap package */
return [

    'root' => env('SITEMAP_ROOT', storage_path('files/sitemaps')),
    'POST_chunk' => 15000,

    'categories' => [
        'enabled'     => env('SITEMAP_CATEGORY_GEN', true),
        'part_size'   => env('SITEMAP_CATEGORY_SIZE', 'auto'),   // auto mean 15k with images, 20k without images
        'min_pages'   => env('SITEMAP_CATEGORY_MIN_PAGES', 1),   // limit sitemap document by document page length
        'max_images'  => env('SITEMAP_CATEGORY_IMAGES', 1),      // 0 to disable
        'chunk'       => env('SITEMAP_CATEGORY_CHUNK', 2000),
        'min_sitemap' => env('SITEMAP_MIN_CATEGORY', 0),
    ],

    'documents' => [
        'enabled'     => env('SITEMAP_DOCUMENT_GEN', true),
        'part_size'   => env('SITEMAP_DOCUMENT_SIZE', 'auto'),   // auto mean 15k with images, 20k without images
        'min_pages'   => env('SITEMAP_DOCUMENT_MIN_PAGES', 1),   // limit sitemap document by document page length
        'max_images'  => env('SITEMAP_DOCUMENT_IMAGES', 1),      // 0 to disable
        'chunk'       => env('SITEMAP_DOCUMENT_CHUNK', 2000),
        'min_sitemap' => env('SITEMAP_MIN_DOCUMENT', 0),
    ],

];
