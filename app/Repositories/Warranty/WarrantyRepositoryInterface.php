<?php

namespace App\Repositories\Warranty;

use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Warranty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface WarrantyRepositoryInterface
{

    public function list(string $trashed=null);

    public function store(array $data):Model;

    public function find(int $id);

    public function withTrashed(int $id);

    public function update(Warranty|Model $warranty,array $data):bool;

    public function delete(int $warrantyId):bool;

    public function trashed();

    public function restore(Warranty|Model $warranty):Warranty;

    public function remove_items(array $warrantyIds);

    public function restore_items(array $warrantyIds);

}
