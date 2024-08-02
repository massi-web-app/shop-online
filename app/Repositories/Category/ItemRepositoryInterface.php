<?php

namespace App\Repositories\Category;

interface ItemRepositoryInterface
{

    public function addItem(int $category_id,array $items, array $child_item, array $check_box);

}
