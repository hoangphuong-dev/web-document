<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Document;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\Document\DocumentService;
use Helpers\Formatter;

class URLGenerate
{
    /**
     * Lấy trang detail
     *
     * @param  Document|int  $document
     * @param  string  $docName
     * @return string
     */
    public static function urlDocumentDetail(Document|string $document, string $slug = ""): string
    {
        if ($document instanceof Document) {
            $slug = $document->slug;
        }

        $slug = $slug ?: '-';
        $slug = substr($slug, 0, 150);
        $uuid = DocumentService::getHashHandler()->encode($document->id ?? $document);

        return route('document.show', [
            'slug'     => $slug,
            'document' => $uuid,
        ]);
    }

    public static function urlCat(int|Category $category, ?string $name = ''): string
    {
        [$id, $name] = $category instanceof Category ? [$category->id, $category->name] : [$category, $name];
        return route('category.index', [Formatter::slug($name), $id]);
    }

    public static function urlTag(int|Tag $tag, ?string $name = ''): string
    {
        [$id, $name] = $tag instanceof Tag ? [$tag->id, $tag->name] : [$tag, $name];
        return route('tag.index', [Formatter::slug($name), $id]);
    }

    public static function urlTopic(int|Topic $topic, ?string $name = ''): string
    {
        [$id, $name] = $topic instanceof Topic ? [$topic->id, $topic->name] : [$topic, $name];
        return route('topic.index', [Formatter::slug($name), $id]);
    }
}
