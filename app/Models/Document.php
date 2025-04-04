<?php

namespace App\Models;

use App\Data\Document\CoverData;
use App\Enums\ActiveStatus;
use App\Enums\Document\ConvertStatus;
use App\Enums\Document\DocumentExt;
use App\Enums\Document\DocumentStatus;
use App\Helpers\URLGenerate;
use App\Models\Traits\AdvancedFilters;
use App\Services\Category\CategoryService;
use App\Services\Document\DocumentService;
use App\Services\Storage\DiskPathService;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

/**
 * @property int $id
 * @property string $title
 * @property string $uuid
 * @property string $slug
 * @property string $image
 * @property string $path
 * @property string $uploaded_ip
 * @property string $file_name
 * @property int $owner_id
 * @property int $category_id
 * @property int $pages
 * @property int $file_size
 * @property DocumentExt $ext
 * @property ActiveStatus $active
 * @property DocumentStatus $status
 * @property ConvertStatus $convert_status
 * @property Carbon $admin_active_date
 * @property int $money_sale
 * @property int $number_page
 * @property int $number_view
 * @property int $number_download
 * @property int $file_attach_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */

class Document extends Model
{
    use HasFactory;
    use AdvancedFilters;
    use FilterScope;
    use HasFilter;

    public    $table      = "documents";
    public    $primaryKey = 'id';
    protected $guarded    = [];

    protected $casts = [
        'active'         => ActiveStatus::class,
        'ext'            => DocumentExt::class,
        'status'         => DocumentStatus::class,
        'convert_status' => ConvertStatus::class,
    ];

    protected $appends = ['url'];

    /*
     * -------------------------------------------------
     * ATTRIBUTE
     * -------------------------------------------------
     */
    public function getUrlAttribute(): int|string
    {
        return URLGenerate::urlDocumentDetail($this->id, $this->slug);
    }

    public function getUuidAttribute(): int|string
    {
        return DocumentService::getHashHandler()->encode($this->id);
    }

    public function getBreadcrumbAttribute(): array
    {
        return CategoryService::getBreadcrumbCategory($this->categories);
    }

    public function getFileThumbnailAttribute(): string
    {
        return ext_change($this->file_name, 'jpg');
    }

    public function getFilePreviewAttribute(): string
    {
        return ext_change($this->file_name, 'png');
    }

    public function getFileFulltextAttribute(): string
    {
        return ext_change($this->file_name, 'txt');
    }

    public function getCoverDataAttribute(): ?CoverData
    {
        $cover = json_decode($this->metaData?->ai_cover, true);
        return CoverData::from(array_filter($cover ?? []));
    }

    public function listCover(): array
    {
        $mapping = [
            "authors"            => "Tác giả",
            "organization"       => "Đơn vị/Tổ chức",
            "field"              => "Lĩnh vực",
            "problem"            => "Vấn đề",
            "solution"           => "Giải pháp",
            "type"               => "Loại sáng kiến",
            "implementationYear" => "Năm thực hiện",
            "results"            => "Kết quả",
            "recognitionLevel"   => "Cấp công nhận",
            "location"           => "Địa điểm"

        ];
        $cover = array_filter(json_decode($this->metaData?->ai_cover, true));
        $translatedData = array_combine(
            array_map(fn($key) => $mapping[$key] ?? $key, array_keys($cover)),
            array_values($cover)
        );
        return $translatedData;
    }

    /*
     * -------------------------------------------------
     * FUNCTION
     * -------------------------------------------------
     */
    public function urlThumbnail(string $size = 'L'): string
    {
        return DiskPathService::urlThumbnail($this->file_thumbnail, $size);
    }

    public function urlPreviewDocument()
    {
        return DiskPathService::urlPreview($this->file_preview);
    }

    /*
     * -------------------------------------------------
     * SCOPE
     * -------------------------------------------------
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query
            ->whereHas('metaData', function ($q) {
                return $q->whereNotNull('ai_summary');
            })
            ->where([
                'active'         => ActiveStatus::ACTIVE,
                'status'         => DocumentStatus::APPROVED,
                'convert_status' => ConvertStatus::SUCCESS,
            ]);
    }

    /*
     * -------------------------------------------------
     * RELATIONSHIP
     * -------------------------------------------------
     */

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'document_tags');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'document_topics');
    }

    public function metaData(): HasOne
    {
        return $this->hasOne(DocumentMetaData::class);
    }

    public function tmpUpload(): HasOne
    {
        return $this->hasOne(TmpUpload::class);
    }

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function getOwnerName(): string
    {
        return 'Ẩn danh';
        return $this?->user?->full_name ?: 'Ẩn danh';
    }

    /*
     * Lấy giá bán của tài liệu
     */
    public function getMoneySell(): int
    {
        return $this->money_sale ?: config('document.validator.default.sale_document.min_price');
    }

    public function isPublic(): bool
    {
        return $this->active->is(ActiveStatus::ACTIVE)
            && $this->status->is(DocumentStatus::APPROVED)
            && !empty($this->metaData?->ai_summary)
            && $this->convert_status->is(ConvertStatus::SUCCESS);
    }

    public function isDeleted(): bool
    {
        return $this->status->in([DocumentStatus::USER_DELETE, DocumentStatus::ADMIN_DELETE]);
    }
}
