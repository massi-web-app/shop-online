<?php

namespace App\Repositories\Brand;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface BrandRepositoryInterface
{

    public function list(string $trashed=null);

    public function getChildAndCategories():array | Collection;

    public function store(array $data):Model;

    public function find(int $id);

    public function update(Brand $brand,array $data):bool;

    public function delete(int $brandId):bool;

    public function trashed();

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $category):Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null;

}
