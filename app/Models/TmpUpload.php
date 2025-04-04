<?php

namespace App\Models;

use App\Models\Traits\AdvancedFilters;
use App\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

class TmpUpload extends Model
{
    use HasFactory;

    use HasFactory;
    use AdvancedFilters;
    use FilterScope;
    use HasFilter;

    public    $primaryKey = 'id';
    protected $guarded    = [];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
