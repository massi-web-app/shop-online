<?php

namespace App\Services\Category\Service;

use App\Repositories\Category\ItemRepository;
use Illuminate\Http\Request;

class ItemService
{


    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {

        $this->itemRepository = $itemRepository;
    }

    public function add_item(int $category_id,Request $request)
    {
        $items=$request->get('item',array());
        $child_item=$request->get('child_item',array());
        $check_box=$request->get('check_box_item',array());

        $this->itemRepository->addItem($category_id,$items,$child_item,$check_box);

    }
}
