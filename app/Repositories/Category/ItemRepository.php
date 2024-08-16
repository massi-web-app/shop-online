<?php

namespace App\Repositories\Category;

use App\Models\Item;
use App\Models\ItemValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ItemRepository implements ItemRepositoryInterface
{


    public function find(int $itemId)
    {
        return Item::query()->findOrFail($itemId);
    }
    public function addItem(int $category_id, array $items, array $child_item, array $check_box)
    {
        $parent_position = 0;
        Item::query()->where(['category_id' => $category_id, 'parent_id' => null])->update(['position' => 0]);
        foreach ($items as $key => $item) {
            if (!empty($item)) {
                $parent_position++;
                if ($key < 0) {
                    $id = Item::query()->insertGetId([
                        'title' => $item,
                        'category_id' => $category_id,
                        'parent_id' => null,
                        'position' => $parent_position
                    ]);
                    $this->addChildItem($key, $child_item, $id, $check_box, $category_id);
                } else {
                    Item::query()->where([
                        'id' => $key,
                    ])->update([
                        'title' => $item,
                        'position' => $parent_position
                    ]);
                    $this->addChildItem($key, $child_item, $key, $check_box, $category_id);
                }

            }
        }

    }

    public function addChildItem(int|string $key, array $child_item, int $item_id, array $check_box, int $category_id)
    {
        if (array_key_exists($key, $child_item)) {
            $child_position = 0;
            Item::query()->where(['parent_id' => $item_id])->update(['position' => 0]);

            foreach ($child_item[$key] as $key_child => $value_child) {
                if (!empty($value_child)) {
                    $child_position++;
                    $item_important = $this->getImportantItem($check_box, $key, $key_child);
                    if ($key_child < 0) {
                        Item::query()->insert([
                            'title' => $value_child,
                            'parent_id' => $item_id,
                            'category_id' => $category_id,
                            'position' => $child_position,
                            'item_important' => $item_important
                        ]);
                    } else {
                        Item::query()->where([
                            'id' => $key_child,
                        ])->update([
                            'title' => $value_child,
                            'position' => $child_position,
                            'item_important' => $item_important
                        ]);
                    }
                }
            }
        }

    }

    public function getImportantItem(array $check_box, int|string $key, int|string $key_child): int
    {
        if (array_key_exists($key, $check_box)) {
            if (array_key_exists($key_child, $check_box[$key])) {
                return 1;
            }
        }
        return 0;
    }

    public function getItems(int $categoryId)
    {
        return Item::with(['getChild.getValue'])->where([
            'category_id' => $categoryId,
            'parent_id' => null
        ])->orderBy('position', 'asc')->get();
    }

    public function removeItem(int $itemId)
    {
        $item=$this->find($itemId);
        $item->delete();
    }

    public function getItemProducts(array $categoryIds)
    {
        return Item::with('getChild')->where(['parent_id'=>null])->whereIn('category_id',$categoryIds)
            ->orderBy('position','ASC')->get();
    }

    public function clear_product_value(Model|Collection $product)
    {
        ItemValue::query()->where(['product_id'=>$product->id])->delete();
    }

    public function add_item_value_to_product(Model|Collection $product, int|string $item_id, mixed $item_value)
    {
        ItemValue::query()->create([
            'product_id'=>$product->id,
            'item_id'=>$item_id,
            'value'=>$item_value
        ]);
    }
}
