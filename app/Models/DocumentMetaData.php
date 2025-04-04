<?php

namespace App\Models;

use App\Data\Document\BasicData;
use App\Models\Traits\AdvancedFilters;
use App\Services\Document\MetaData\MetaDataService as Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

class DocumentMetaData extends Model
{
    use HasFactory;
    use HasFilter;
    use AdvancedFilters;

    public    $table   = "document_meta_data";
    protected $guarded = [];

    public $timestamps = false;

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function getAiTopicalAttribute(): string
    {
        return Service::topicalToHtml($this->attributes['ai_topical']);
    }

    public function getAiTagAttribute(): array
    {
        $tags   = explode(',', $this->attributes['ai_tag']);
        $arrTag = $this->mapTagOrTopic($tags);
        $arrTag = array_slice($arrTag, 0, 5); // * chỉ show tối đa 5 tags
        return empty($arrTag) ? [] : BasicData::collect($arrTag);
    }

    public function getAiTopicAttribute(): array
    {
        $topics   = explode(',', $this->attributes['ai_topic']);
        $arrTopic = $this->mapTagOrTopic($topics);
        return empty($arrTopic) ? [] : BasicData::collect($arrTopic);
    }

    protected static function booted()
    {
        static::updated(fn($docMeta) => Service::updateTimeDocument($docMeta));
    }

    private function mapTagOrTopic(array $data)
    {
        return array_filter(array_map(function ($tag) {
            $arr = explode(':', $tag);
            return count($arr) > 1 ? ['id' => Arr::first($arr), 'name' => Arr::last($arr)] : null;
        }, $data));
    }
}
