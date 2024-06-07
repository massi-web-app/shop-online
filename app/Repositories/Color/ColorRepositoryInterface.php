<?php

namespace App\Repositories\Color;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ColorRepositoryInterface
{

    public function list(string $trashed=null);

    public function store(array $data):Model;

    public function find(int $id);

    public function update(Color $category,array $data):bool;

    public function delete(int $categoryId):bool;

    public function trashed();

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $category):Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null;

}
