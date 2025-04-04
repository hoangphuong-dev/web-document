<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\SEO\SeoService;
use App\Services\Tag\TagService;

class TagController extends Controller
{
    public function index(?string $slug, Tag $tag)
    {
        $instance  = $tag;
        $documents = TagService::documentByTag($tag);

        $this->seo($tag, $documents->items());
        if ($documents->count() == 0) {
            abort(404);
        }
        return view('tags-topics.list', compact('documents', 'instance'));
    }

    private function seo(Tag $tag, array $documents)
    {
        $title       = $tag->ai_title ?: "Tổng hợp tài liệu - {$tag->name}";
        $description = $tag->ai_description ?:
            "Tổng hợp tài liệu {$tag->name} với những tài liệu chất lượng. Cung cấp nguồn tài nguyên phong phú giúp nâng cao kiến thức và kỹ năng học tập hiệu quả.";
        SeoService::seoTitle($title);
        SeoService::seoDescription($description);
        SeoService::setCanonical(current_url());
        SeoService::seoListItem($title, $description, $documents);
    }
}
