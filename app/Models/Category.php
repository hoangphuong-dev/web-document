<?php

namespace App\Models;

use App\Services\Category\CategoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $active
 * @property int $parent_id
 * @property int $parent_id_1
 * @property string $list_child_all
 */
class Category extends Model
{
    use HasFactory;

    protected $table      = "categories";
    public    $timestamps = false;
    protected $guarded    = [];

    /*
     * -------------------------------------------------
     * ATTRIBUTE
     * -------------------------------------------------
     */

    public function getBreadcrumbAttribute(): array
    {
        return CategoryService::getBreadcrumbCategory($this);
    }
}
