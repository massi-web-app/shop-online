<?php

namespace App\Repositories\Category;

use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{


    public function addItem(int $category_id, array $items, array $child_item, array $check_box)
    {
        $parent_position = 0;
        foreach ($items as $key => $item) {
            if ($key < 0 && !empty($item)) {
                $parent_position++;
                $id = Item::query()->insertGetId([
                    'title' => $item,
                    'category_id' => $category_id,
                    'parent_id' => null,
                    'position' => $parent_position
                ]);
            }
        }

    }
}
