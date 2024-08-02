<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Category\Service\CategoryService;
use App\Services\Category\Service\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    private CategoryService $categoryService;
    private ItemService $itemService;

    public function __construct(CategoryService $categoryService, ItemService $itemService)
    {

        $this->categoryService = $categoryService;
        $this->itemService = $itemService;
    }

    public function items(int $categoryId)
    {
        $category = $this->categoryService->find($categoryId);
        return view('item.index', ['category' => $category]);
    }

    public function add_item(int $category_id,Request $request)
    {
        $this->itemService->add_item($category_id,$request);
//        return redirect()->back()->with('message', 'ثبت مشخصات فنی با موفقیت انجام شد.');
    }
}
