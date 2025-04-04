<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait AdvancedFilters
{
    public function scopeIdRange(Builder $query, $id, $field = 'id')
    {
        return $query->when($id, function (Builder $query) use ($id, $field) {
            if (strpos($id, '-')) {
                [$min, $max] = explode("-", $id);
                $query->where($field, ">=", $min);
                $query->where($field, "<=", $max);
            } elseif (strpos($id, ',')) {
                $ids = explode(',', $id);
                $query->whereIn($field, $ids);
            } else {
                $query->where($field, $id);
            }
        });
    }
}
