<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use LaravelLegends\EloquentFilter\Concerns\HasFilter;

class Tag extends Model
{
    use HasFactory;
    use HasFactory;
    use HasFilter;

    protected $guarded = [];

    public $timestamps = false;

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_tags');
    }
}
