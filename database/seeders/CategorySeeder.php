<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pathFile = database_path('seeders/categories.sql');

        DB::unprepared(file_get_contents($pathFile));

        dump('Suceess seeder !');
    }

    private function mapCat()
    {
        $cats = Category::get();
        foreach ($cats as $cat) {
            if ($cat->parent_id == 0) {
                $listChild = $cats->where('parent_id', $cat->id);
                if ($listChild->count() > 0) {

                    $arrChild = [];
                    $arrChild[] = $listChild->pluck('id')->implode(',');
                    foreach ($listChild as $child) {
                        if (!empty($child->list_child_all)) {
                            $arrChild[] = $child->list_child_all;
                        }
                    }

                    if (!empty($arrChild)) {
                        $cat->list_child_all = collect($arrChild)->implode(',');
                        $cat->save();
                    }
                }
            }
        }
    }
}
