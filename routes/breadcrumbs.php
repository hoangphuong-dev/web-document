<?php

use App\Helpers\URLGenerate;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('index', [], false), ['isHome' => true]);
});

// Trang search document
Breadcrumbs::for('search-document', function (BreadcrumbTrail $trail, $keyword) {
    $trail->parent('index');
    $trail->push('Kết quả tìm kiếm', route('search-document', ['keyword' => $keyword]));
});

// Breadcrumbs cho document
Breadcrumbs::for('document-category', function (BreadcrumbTrail $trail, array $arrCat, bool $isHome = true) {
    if ($isHome) {
        $trail->parent('index');
    }
    foreach ($arrCat as $cate) {
        $trail->push(
            title: $cate['name'],
            url  : URLGenerate::urlCat($cate['id'], $cate['name']),
        );
    }
});
