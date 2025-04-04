<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModelFilteredController extends Controller
{
    public function filtered(Request $request)
    {
        // User::$dont_hidden = true;
        $model   = $request->get('model');
        $columns = Arr::wrap($request->get('columns', ['*']));
        $limit   = $request->get('limit', 30);

        $query = app($model)->filter($request);
        if ($with = $request->get('with')) {
            $query->with($with);
        }

        if ($orderBy = Arr::wrap($request->get('order') ?: $request->get('orderBy') ?: $request->get('sort') ?: [])) {
            $query->orderBy(...$orderBy);
        }

        $result = $query->simplePaginate($limit, $columns);
        $items = $request->get('raw')
            ? $result->items()
            : $result->map(fn(Model $model) => $model->toArray());

        return [
            'per_page'      => $result->perPage(),
            'current_page'  => $result->currentPage(),
            'path'          => $result->path(),
            'next_page_url' => $result->nextPageUrl(),
            'data'          => $items,
        ];
    }
}
