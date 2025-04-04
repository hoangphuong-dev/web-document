<?php

namespace App\Services\Document;

use Helpers\KeywordLibrary;
use App\Models\Document;
use App\Services\Storage\DiskPathService;
use Hash\HashId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DocumentService
{
    public static function getHashHandler(): HashId
    {
        return new HashId('document', 10, '0123456789');
    }

    public static function fetchCachePageHome(): array
    {
        $driverCache  = Cache::driver('database');
        $latest       = $driverCache->get('latest_document', []);
        $multipleDown = $driverCache->get('multiple_download_document', []);
        $mostView     = $driverCache->get('most_view_document', []);
        return [$latest, $multipleDown, $mostView];
    }

    public static function getFulltext(Document $document): string
    {
        return DiskPathService::getFulltext($document->path, $document->file_fulltext) ?? '';
    }

    public static function formatFulltext(Document $document)
    {
        $desc     = static::getFulltext($document);
        // Tách đoạn văn bản thành các dòng
        $arrDesc    = preg_split('/[\n.]/', $desc);
        $arrContent = array_map(function ($content) use ($document) {
            $content = KeywordLibrary::removeSortSentences($content);
            $content = KeywordLibrary::searchKeyword($document->title, $content);
            return empty($content) ? '' : "<p>$content</p>";
        }, $arrDesc);

        // limit 100 dòng
        $arrContent = array_slice(array_filter($arrContent), 0, 20);
        $desc       = implode("\n", $arrContent);
        return $desc;
    }

    public static function getSummary(Document $document)
    {
        $summary = $document->metaData?->ai_summary ?? $document->sumary;
        return empty($summary) ? static::formatFulltext($document) : SummaryService::toHtml(json_decode($summary, true));
    }

    public static function getDocumentByCategory(array $arrListCat)
    {
        return Document::query()
            ->whereIn('category_id', $arrListCat)
            ->public()
            ->with(['categories'])
            ->simplePaginate(10);
    }

    /**
     * Gen link trang tải 1 lần
     *
     * @param  int  $docId
     * @param  string|int  $user
     * @param  array  $parameters
     * @return string
     */
    public static function urlDownloadOneTimePage(int $docId, string|int $user, array $parameters = []): string
    {
        return '';
        // return UrlSignerService::sign(
        //     tokenableId: $user,
        //     routeName: 'document.download_one_time',
        //     expiration: config('common.auth_code.timeout'),
        //     parameters: array_merge(['doc_id' => $docId], $parameters)
        // );
    }

    public static function getNewDocument()
    {
        return Document::query()->public()->with('categories')->latest()->limit(10)->get();
    }

    public static function getMultiDownloadDoc()
    {
        return Document::query()->public()->with('categories')->orderByDesc('number_download')->limit(10)->get();
    }
    
    public static function getMostViewDoc()
    {
        return Document::query()->public()->with('categories')->orderByDesc('number_view')->limit(10)->get();
    }

    public static function getDocumentRelated(Document $document)
    {
        // todo: Lấy tài liệu liên quan trên search engine
        return Document::public()->where('category_id', $document->category_id)->limit(7)->get();
    }

    public static function getDocumentByIds(array $ids, array $relations = []): ?Collection
    {
        $strId = implode(',', $ids);
        return Document::query()
            ->whereIn('id', $ids)
            ->forceIndex("PRIMARY")
            ->public()
            ->when(!empty($relations), function (Builder $query) use ($relations) {
                $query->with($relations);
            })
            ->when(!empty($strId), function ($q) use ($strId) {
                return $q->orderByRaw("FIELD(id, {$strId})");
            })
            ->get();
    }

    public static function first(int $docId, array $select = [], array $relations = [], bool $isPublish = false): ?Document
    {
        return Document::query()
            ->when(!empty($select), function (Builder $query) use ($select) {
                $query->select($select);
            })
            ->whereId($docId)
            ->forceIndex('PRIMARY')
            ->when(!empty($relations), function (Builder $query) use ($relations) {
                $query->with($relations);
            })
            ->when($isPublish, function (Builder $query) {
                $query->public();
            })
            ->first();
    }
}
