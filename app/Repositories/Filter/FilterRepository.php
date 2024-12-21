<?php

namespace App\Repositories\Filter;

use App\Models\Category;
use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FilterRepository implements FilterInterface
{


    public function addFilter(Collection|Model $category, array $child_filter, array $filters, $item_value)
    {
        $parent_position = 0;
        Filter::query()->where(['category_id' => $category->id, 'parent_id' => null])->update(['position' => 0]);
        foreach ($filters as $key_filter => $filter) {
            if (!empty($filter)) {
                $parent_position++;
                $item_id = array_key_exists($key_filter, $item_value) ? $item_value[$key_filter] : null;
                if ($key_filter < 0) {
                    $id = Filter::query()->insertGetId([
                        'title' => $filter,
                        'category_id' => $category->id,
                        'parent_id' => null,
                        'position' => $parent_position,
                        'item_id' => $item_id
                    ]);
                    $this->addChildFilter($key_filter, $child_filter, $id, $category->id);
                } else {
                    Filter::query()->where([
                        'id' => $key_filter,
                    ])->update([
                        'title' => $filter,
                        'position' => $parent_position,
                        'item_id' => $item_id == 0 ? null : $item_id
                    ]);
                    $this->addChildFilter($key_filter, $child_filter, $key_filter, $category->id);
                }
            }
        }
    }

    private function addChildFilter(int|string $key_filter, array|null $child_filter, int|string $filter_id, int $category_id)
    {

        if (array_key_exists($key_filter, $child_filter)) {
            $child_position = 0;
            Filter::query()->where(['parent_id' => $filter_id])->update(['position' => 0]);

            foreach ($child_filter[$key_filter] as $key_child => $value_child) {
                if (!empty($value_child)) {
                    $child_position++;
                    if ($key_child < 0) {
                        Filter::query()->insert([
                            'title' => $value_child,
                            'parent_id' => $filter_id,
                            'category_id' => $category_id,
                            'position' => $child_position,
                        ]);
                    } else {
                        Filter::query()->where([
                            'id' => $key_child,
                        ])->update([
                            'title' => $value_child,
                            'position' => $child_position,
                        ]);
                    }
                }
            }
        }


    }

    public function list(Model|Category $category)
    {
        return Filter::with(['getChild'])->where([
            'category_id' => $category->id,
            'parent_id' => null
        ])->orderBy('position', 'ASC')->get();

    }

}
