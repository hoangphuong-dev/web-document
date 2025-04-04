<?php

namespace App\Services\Category;

use App\Enums\ActiveStatus;
use App\Enums\Category\CategoryType;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public static $catAll;

    /**
     * Lấy arr danh mục con và danh mục cha từ danh mục cha
     *
     * @param  mixed $catId
     * @return array
     */
    public static function getArrCatChild(Category $category): array
    {
        $arrCatChild = array_map('intval', explode(',', $category->list_child_all));
        return array_filter(array_merge([$category->id], $arrCatChild));
    }

    /**
     * Lấy toàn bộ cat từ database
     *
     * @return Collection
     */
    public static function forceCatAll(): Collection
    {
        // lấy từ trong cache ra 
        $value = Cache::get('cat_all');

        if (empty($value)) {
            static::$catAll = $value = Category::get();
            // set cache 
            Cache::put('cat_all', static::$catAll, now()->addHour(24));
        }

        return $value;
    }

    /**
     * Lấy các cate phân loại theo từng cấp parent, lv1, lv2, lv3
     *
     * @param  string  $type
     * @param  int|null  $parentId
     * @param  int|null  $primary
     * @return array
     */
    public static function getMenuDocCat(string $type = 'all', ?int $parentId = null, ?int $primary = null): array
    {
        $menuDocCat   = static::menuDocCatLeft();

        $cateParent   = Arr::get($menuDocCat, 'menuParent', collect());
        $cateChildLv3 = collect();
        $cateChildLv2 = collect();
        $cateChildLv1 = collect();

        if ($type == 'onlyParent') {
            goto END;
        }

        $isLoadChildLv3 = $type == 'all';
        $isLoadChildLv2 = (!is_null($parentId) && !is_null($primary) && $type == 'secondChild') || $isLoadChildLv3;
        $isLoadChildLv1 = (!is_null($parentId) && $type == 'firstChild') || $isLoadChildLv2;

        /**
         * @var Collection $menuChild
         */
        $menuChild = (Arr::get($menuDocCat, 'menuChild', collect()));
        foreach ($menuChild as $cate) {
            if ($isLoadChildLv3 && $cate->cat_parent_id_3 > 0) {
                $cateChildLv3->push($cate);
                continue;
            }

            if ($isLoadChildLv2 && $cate->cat_parent_id_2 > 0) {
                $cateChildLv2->push($cate);
                continue;
            }

            if ($isLoadChildLv1 && $cate->cat_parent_id_1 > 0) {
                $cateChildLv1->push($cate);
            }
        }

        if ($type == 'all') {
            goto END;
        }

        if ($isLoadChildLv1) {
            $cateChildLv1 = $cateChildLv1->where('cat_parent_id', $parentId);
            goto END;
        }

        if ($isLoadChildLv2) {
            $cateChildLv1 = $cateChildLv1->where('cat_parent_id', $parentId);
            $cateChildLv2 = $cateChildLv2->where('cat_parent_id', $primary);
        }

        END:
        return [
            'menuParent'   => $cateParent,
            'menuChildLv1' => $cateChildLv1,
            'menuChildLv2' => $cateChildLv2,
            'menuChildLv3' => $cateChildLv3,
        ];
    }


    /**
     * Lấy ra các cate gốc và cate con được nhóm theo id của cate cha
     *
     * @return array
     */
    public static function menuDocCatLeft(): array
    {
        $menuParent = static::getCategoryByLevel('parent');
        $menuChild  = static::getCategoryByLevel('child');
        return [
            'menuParent' => $menuParent,
            'menuChild'  => $menuChild,
        ];
    }

    private static function getCategoryByLevel(?string $level = null): Collection
    {
        return Category::query()
            ->where('active', ActiveStatus::ACTIVE)
            // ->where('type', CategoryType::DOCUMENT)
            ->when($level, function ($q) use ($level) {
                return match ($level) {
                    'parent' => $q->where('parent_id', 0),
                    'child'  => $q->where('parent_id_1', '<>', 0),
                    default  => $q,
                };
            })
            ->get();
    }

    /**
     * Lấy breadcrum của tài liệu
     *
     * @param ?Category $category
     *
     * @return array
     */
    public static function getBreadcrumbCategory(?Category $category): array
    {
        if (is_null($category)) {
            return [];
        }

        if ($category->parent_id == 0) {
            return [['id' => $category->id, 'name' => $category->name]];
        }

        $allCat = static::forceCatAll();
        if (empty($allCat)) {
            return [];
        }

        $parentFirst = $allCat->firstWhere('id', $category->parent_id);
        if (is_null($parentFirst)) {
            return [['id' => $category->id, 'name' => $category->name]];
        }

        if ($parentFirst->parent_id_1 == 0) {
            return [
                ['id' => $parentFirst->id, 'name' => $parentFirst->name],
                ['id' => $category->id, 'name' => $category->name],
            ];
        }

        $parentSecond = $allCat->firstWhere('id', $parentFirst->parent_id);
        return [
            ['id' => $parentSecond->id, 'name' => $parentSecond->name],
            ['id' => $parentFirst->id, 'name' => $parentFirst->name],
            ['id' => $category->id, 'name' => $category->name],
        ];
    }
}
