<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\Item;
use App\Services\Category\Service\CategoryService;
use App\Services\Category\Service\ItemService;
use App\Services\Filter\FilterService;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    private FilterService $filterService;
    private CategoryService $categoryService;
    private ItemService $itemService;

    public function __construct(FilterService $filterService, CategoryService $categoryService,ItemService $itemService)
    {
        $this->filterService = $filterService;
        $this->categoryService = $categoryService;
        $this->itemService = $itemService;
    }

    public function filters(int $categoryId)
    {
        $category = $this->categoryService->find($categoryId);
        $filters = $this->filterService->items($category);
        $items=$this->itemService->getCategoryItem($categoryId);
        return view('filter.index', ['filters' => $filters, 'category' => $category,'items'=>$items]);
    }

    public function add_filter(int $categoryId, Request $request)
    {
        $category = $this->categoryService->find($categoryId);
        $filter = $request->get('filter', []);
        $item_value=$request->get('item_id',[]);
        $child_filter = $request->get('child_item', []);
        $this->filterService->addFilter($category, $child_filter, $filter,$item_value);
        return redirect()->back()->with('message', 'ثبت فیلتر ها با موفقیت انجام شد');
    }

    public function remove_filter(int $item_id)
    {
        $filter = Filter::query()->findOrFail($item_id);
        $filter->getChild()->delete();
        $filter->delete();
        return redirect()->back()->with('message', 'حذف فیلتر ها با موفقیت انجام شد');
    }
}
