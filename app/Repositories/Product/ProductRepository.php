<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{

    public function list(string $trashed = null)
    {
        // TODO: Implement list() method.
    }

    public function store(array $data): Model
    {
        // TODO: Implement store() method.
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
    }

    public function update(Product $product, array $data): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(int $categoryId): bool
    {
        // TODO: Implement delete() method.
    }

    public function trashed()
    {
        // TODO: Implement trashed() method.
    }

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $category): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
    {
        // TODO: Implement restore() method.
    }
}
