<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{

    public function list(string $trashed = null);

    public function store(array $data): Model;

    public function find(int $id);

    public function update(Product $product, array $data): bool;

    public function delete(int $categoryId): bool;

    public function trashed();

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $category): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null;

    public function getStatus(): array;

}
