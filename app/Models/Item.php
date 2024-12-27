<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    //region model config
    use HasFactory;

    protected $table = 'items';
    protected $fillable = ['category_id', 'title', 'position', 'item_important', 'parent_id'];
    //endregion

    //region relations
    public static function addFilter($key, $filter_value, $product_id)
    {
        if (array_key_exists($key, $filter_value)) {
            foreach ($filter_value[$key] as $k => $value) {
                $filter_id = $k;

                ProductFilters::query()->where(['product_id' => $product_id, 'filter_id' => $filter_id])->delete();
                $new_filter_value = explode('@', $value);
                foreach ($new_filter_value as $key => $new_filter_value_item) {
                    if (!empty($new_filter_value_item)) {
                        ProductFilters::query()->create([
                            'product_id' => $product_id,
                            'filter_id' => $filter_id,
                            'filter_value' => $new_filter_value_item
                        ]);
                    }
                }
            }
        }

    }

    public function getChild()
    {
        return $this->hasMany(Item::class, 'parent_id', 'id')->orderBy('position', 'ASC');
    }

    public function getValue()
    {
        return $this->hasMany(ItemValue::class, 'item_id', 'id')
            ->where('product_id', product_id);
    }
    //endregion


    //region methods

    public static function getProductItemWithFilter($product)
    {
        define('product_id', $product->id);
        $category = Category::query()->find($product->id);
        $category_ids[0] = $product->category_id;
        if ($category) {
            $category_ids[1] = $category->parent_id;
        }
        $items = Item::with('getChild.getValue')->where(['parent_id' => null])
            ->whereIn('category_id', $category_ids)
            ->orderBy('position', 'ASC')->get();


        $filters = Filter::query()->whereIn('category_id', $category_ids)
            ->where(['parent_id' => null])->whereNotNull('item_id')->with('getChild')->get();

        return ['items' => $items, 'filters' => $filters];
    }
    //endregion

}
