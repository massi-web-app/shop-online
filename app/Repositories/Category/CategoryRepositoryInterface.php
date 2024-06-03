<?php

namespace App\Repositories\Category;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{

    public function list():array | LengthAwarePaginator;

    public function getChildAndCategories():array | Collection;

    public function store(array $data):Model;

    public function find(int $id);

    public function update(Category $category,array $data):bool;

    public function delete();

}
