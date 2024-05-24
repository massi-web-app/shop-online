<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryRepository->store($request->all());
        return redirect()->route('category.index')->with('message','ثبت دسته با موفقیت انجام شد.');
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
