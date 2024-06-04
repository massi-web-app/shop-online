<?php

namespace App\Services\Category\Service;

use App\Helper\Helper;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public static int $paginate = 10;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list(?string $trashed)
    {
        $queryString = '?';
        $categories = $this->categoryRepository->list();
        if ($trashed == 'true') {
            $categories = $categories->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }
        $categories = $categories->paginate(self::$paginate);
        $categories->withPath($queryString);
        return $categories;
    }

    public function countTrashed()
    {
        return $this->categoryRepository->trashed()->count();
    }

    public function removeItems(Request $request)
    {
        $this->categoryRepository->remove_items($request->get('category_id'));

    }

    public function restoreItems(Request $request)
    {
        $this->categoryRepository->restore_items($request->get('category_id'));
    }

    public function restore(int $categoryId)
    {
        $category=$this->categoryRepository->withTrashed($categoryId);
        $this->categoryRepository->restore($category);
        return true;
    }

}
