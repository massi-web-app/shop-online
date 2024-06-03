<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepository;
use App\Services\Uploader\Uploader;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;
    private Uploader $uploader;

    public function __construct(CategoryRepository $categoryRepository, Uploader $uploader)
    {
        $this->categoryRepository = $categoryRepository;
        $this->uploader = $uploader;
    }

    public function index()
    {
        $categories = $this->categoryRepository->list();
        $paginate = CategoryRepository::$paginate;
        return view('category.index', ['categories' => $categories, 'paginate' => $paginate]);
    }

    public function create()
    {
        $parent_categories = $this->categoryRepository->getChildAndCategories();
        return view('category.create', ['parent_categories' => $parent_categories]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $image = $this->uploader->upload($request->file('image'), 'files/upload');
        $data['img'] = $image;
        $this->categoryRepository->store($data);
        return redirect()->route('category.index')->with('message', 'ثبت دسته با موفقیت انجام شد.');
    }

    public function edit(int $categoryId)
    {
        $category = $this->categoryRepository->find($categoryId);
        $parent_categories = $this->categoryRepository->getChildAndCategories();
        return view('category.edit', ['parent_categories' => $parent_categories, 'category' => $category]);
    }

    public function update(int $categoryId, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->find($categoryId);
        $this->uploader->removeFile('files/upload',$category->img);
        $data = $request->all();
        $image = $this->uploader->upload($request->file('image'), 'files/upload');
        $data['img'] = $image;
        $this->categoryRepository->update($category, $data);
        return redirect()->route('category.index')->with('message', 'ویرایش دسته بندی با موفقیت انجام شد.');

    }

    public function destroy()
    {

    }


}
