<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterScope
{
    public function scopeQueryFilters(Builder $query, $id = null, $from = null, $to = null, $id_filter = null): Builder
    {
        return $query->when($id, function (Builder $query) use ($id) {
            if (strpos($id, '-')) {
                [$min, $max] = explode('-', $id);
                $query->where('id', '>=', $min);
                $query->where('id', '<=', $max);
            } elseif (strpos($id, ',')) {
                $ids = explode(',', $id);
                $query->whereIn('id', $ids);
            } elseif ($id === 'latest') {
                $query->latest('id');
            } else {
                $query->where('id', $id);
            }
        })->when($from, function (Builder $query) use ($from) {
            $query->where('id', '>=', $from);
        })->when($to, function ($query) use ($to) {
            $query->where('id', '<=', $to);
        })->when($id_filter, function (Builder $query) use ($id_filter) {
            [$divisor, $remainder] = explode(',', $id_filter);
            $query->whereRaw("id % $divisor = $remainder");
        });
    }
}
