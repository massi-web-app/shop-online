<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepository;
use App\Services\Category\Service\CategoryService;
use App\Services\Uploader\Uploader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;
    private CategoryService $categoryService;
    private Uploader $uploader;

    public function __construct(CategoryService $categoryService,CategoryRepository $categoryRepository, Uploader $uploader)
    {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
        $this->uploader = $uploader;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->list($request->get('trashed'));
        $paginate = CategoryService::$paginate;
        $trashed_category_count=$this->categoryService->countTrashed();
        return view('category.index', ['categories' => $categories, 'paginate' => $paginate,
            'trashed_category_count'=>$trashed_category_count]);
    }

    public function create(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $parent_categories = $this->categoryRepository->getChildAndCategories();
        return view('category.create', ['parent_categories' => $parent_categories]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->all();
        $image = $this->uploader->upload($request->file('image'), 'files/upload');
        $data['img'] = $image;
        $this->categoryRepository->store($data);
        return redirect()->route('category.index')->with('message', 'ثبت دسته با موفقیت انجام شد.');
    }

    public function edit(int $categoryId): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $category = $this->categoryRepository->find($categoryId);
        $parent_categories = $this->categoryRepository->getChildAndCategories();
        return view('category.edit', ['parent_categories' => $parent_categories, 'category' => $category]);
    }

    public function update(int $categoryId, UpdateCategoryRequest $request): RedirectResponse
    {
        $category = $this->categoryRepository->find($categoryId);
        $this->uploader->removeFile('files/upload',$category->img);
        $data = $request->all();
        $image = $this->uploader->upload($request->file('image'), 'files/upload');
        $data['img'] = $image;
        $this->categoryRepository->update($category, $data);
        return redirect()->route('category.index')->with('message', 'ویرایش دسته بندی با موفقیت انجام شد.');

    }

    public function destroy(int $categoryId): RedirectResponse
    {
        $this->categoryRepository->delete($categoryId);
        return redirect()->route('category.index')->with('message', 'دسته مورد نظر با موفقیت به سطل زباله انتقال داده شد.');
    }


}
