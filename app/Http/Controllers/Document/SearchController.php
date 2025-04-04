<?php

namespace App\Http\Controllers\Document;

use Helpers\KeywordLibrary;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\SearchDocumentRequest;
use App\Services\Category\CategoryService;
use App\Services\SEO\SeoService;
use App\Services\Sphinx\SphinxSearchService;

class SearchController extends Controller
{
    public function searchDocument(SearchDocumentRequest $request)
    {
        $keyword       = KeywordLibrary::keywordToStandard($request->get('keyword'));
        $requestSearch = array_merge(['keyword' => $keyword], $request->validated());
        $title         = "Kết quả tìm kiếm từ khóa: {$keyword}";
        $appName       = config('app.name');
        $description   = "Tìm kiếm tài liệu về  {$keyword} ? {$appName} chuyên cung cấp tài liệu chất lượng.
                        Khám phá danh sách tài liệu về {$keyword} và nhiều hơn nữa tại {$appName}! Tìm hiểu thêm!";

        SeoService::seoTitle($title);
        SeoService::seoDescription($description);

        $documents  = SphinxSearchService::getDocumentFromSphinx($requestSearch);
        // $categories = CategoryService::getMenuDocCat('onlyParent');
        return view("search.document", [
            'keyword'   => $keyword,
            // 'categories'  => $categories,
            'documents' => $documents
        ]);
    }
}
