<?php

namespace App\Console\Commands\System;

use App\Models\Category;
use Illuminate\Console\Command;

class MapCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:map-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
