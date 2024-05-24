<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

        return view('category.index');
    }

    public function create()
    {
        $parent_categories = $this->categoryRepository->list();
        return view('category.create',['parent_categories'=>$parent_categories]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryRepository->store($request->all());
        return redirect()->route('category.index')->with('message', 'ثبت دسته با موفقیت انجام شد.');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }


}
