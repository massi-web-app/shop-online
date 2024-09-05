<?php

namespace App\Services\Filter;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Filter\FilterRepository;
use App\Services\Category\Service\CategoryService;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

class FilterService
{
    private FilterRepository $filterRepository;
    private CategoryService $categoryService;

    public function __construct(FilterRepository $filterRepository,CategoryService $categoryService)
    {
        $this->filterRepository = $filterRepository;
        $this->categoryService = $categoryService;
    }
    public function items(Category|Model $category)
    {
        return $this->filterRepository->list($category);
    }

    public function addFilter(Collection|Model $category, array $child_filter, array $filter)
    {
        $this->filterRepository->addFilter($category,$child_filter,$filter);

    }


}
