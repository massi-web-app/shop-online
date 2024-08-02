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

    public function find(int $categoryId)
    {
        return $this->categoryRepository->find($categoryId);
    }

    public function store(array $data)
    {
        $this->categoryRepository->store($data);
    }


    public function list(Request $request)
    {
        $queryString = '?';
        $categories = $this->categoryRepository->list();
        if ($request->get('trashed') == 'true') {
            $categories = $categories->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (array_key_exists('string', $request->all()) && !empty($request->get('string'))) {
            $categories = $categories->where('title', 'like', '%' . $request->get('string') . '%');
            $categories = $categories->orWhere('ename', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string='.$request->get('string'));
        }

        $categories = $categories->paginate(self::$paginate);
        $categories->withPath($queryString);
        return $categories;
    }

    public function delete(int $categoryId)
    {
        $this->categoryRepository->delete($categoryId);
    }

    public function countTrashed()
    {
        return $this->categoryRepository->trashed()->count();
    }

    public function restore(int $categoryId)
    {
        $category = $this->categoryRepository->withTrashed($categoryId);
        $this->categoryRepository->restore($category);
        return true;
    }



}
