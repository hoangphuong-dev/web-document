<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Category\CategoryService;
use App\Services\Document\DocumentService;
use App\Services\SEO\SeoService;

class CategoryController extends Controller
{
    public function index(?string $slug, Category $category)
    {
        $arrListCat = CategoryService::getArrCatChild($category);
        $documents  = DocumentService::getDocumentByCategory($arrListCat);
        $this->seo($category, $documents->items());

        return view('categories.list', compact('documents', 'category'));
    }

    private function seo(Category $category, array $documents)
    {
        $title       = "Danh mục tài liệu - {$category->name}";
        $description = "Danh mục tài liệu {$category->name} với những tài liệu chất lượng. 
        Cung cấp nguồn tài nguyên phong phú giúp nâng cao kiến thức và kỹ năng học tập hiệu quả.";

        SeoService::seoTitle($title);
        SeoService::seoDescription($description);
        SeoService::setCanonical(current_url());
        SeoService::seoListItem($title, $description, $documents);
    }
}
