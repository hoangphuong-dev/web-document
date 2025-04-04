<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Services\SEO\SeoService;
use App\Services\Topic\TopicService;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(?string $slug, Topic $topic)
    {
        $instance = $topic;
        $documents = TopicService::documentByTopic($topic);
        $this->seo($topic, $documents->items());

        if ($documents->count() == 0) {
            abort(404);
        }
        return view('tags-topics.list', compact('documents', 'instance'));
    }

    private function seo(Topic $topic, array $documents)
    {
        $title       = $topic->ai_title ?: "Tổng hợp tài liệu chủ đề - {$topic->name}";
        $description = $topic->ai_description ?:
            "Tổng hợp tài liệu chủ đề {$topic->name} với những tài liệu chất lượng. Cung cấp nguồn tài nguyên phong phú giúp nâng cao kiến thức và kỹ năng học tập hiệu quả.";
        SeoService::seoTitle($title);
        SeoService::seoDescription($description);
        SeoService::setCanonical(current_url());
        SeoService::seoListItem($title, $description, $documents);
    }
}
