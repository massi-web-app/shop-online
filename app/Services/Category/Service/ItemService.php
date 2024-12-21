<?php

namespace App\Services\Category\Service;

use App\Models\Product;
use App\Repositories\Category\ItemRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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

    public function getItems(int $categoryId)
    {
        return $this->itemRepository->getItems($categoryId);
    }

    public function removeItem(int $itemId)
    {
        $this->itemRepository->removeItem($itemId);
    }

    public function getItemProduct(array $categories)
    {
        return $this->itemRepository->getItemProducts($categories);
    }

    public function clear_value_items(Model|Collection $product)
    {
        $this->itemRepository->clear_product_value($product);
    }

    public function add_item_value_to_product(Model|Collection $product, int $item_id, string $item_value)
    {
        $this->itemRepository->add_item_value_to_product($product,$item_id,$item_value);
    }

    public function getCategoryItem(int $categoryId)
    {
        return $this->itemRepository->getCategoryItem($categoryId);

    }
}
