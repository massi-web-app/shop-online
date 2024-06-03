<?php

namespace App\Services\Category\Service;

use App\Helper\Helper;
use App\Repositories\Category\CategoryRepository;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public static int $paginate = 2;


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

}
