<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Category\Service\CategoryService;
use App\Services\Filter\FilterService;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    private FilterService $filterService;
    private CategoryService $categoryService;

    public function __construct(FilterService $filterService, CategoryService $categoryService)
    {
        $this->filterService = $filterService;
        $this->categoryService = $categoryService;
    }

    public function filters(int $categoryId)
    {
        $category = $this->categoryService->find($categoryId);
        $filters = $this->filterService->items($category);
        return view('filter.index', ['filters' => $filters, 'category' => $category]);
    }

    public function add_filter(int $categoryId,Request $request)
    {
        $category=$this->categoryService->find($categoryId);
        $filter=$request->get('filter');
        $child_filter=$request->get('child_filter');
        $this->filterService->addFilter($category,$child_filter,$filter);
        return redirect()->back()->with('message','ثبت فیلتر ها با موفقیت انجام شد');
    }
}
