<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{

    public function list(string $trashed = null);

    public function store(array $data): Model;

    public function find(int $id);

    public function update(Product $product, array $data): Product|Model;

    public function delete(int $productId): bool;

    public function trashed();

    public function updateProductColors(Product|Model $product,array $colors):void;

    public function restore(int $productId): void;

    public function remove_items(array $productIds): void;

    public function restore_items(array $productIds): void;

    public function getStatus(): array;

    public function update_product_price(Product|Model|Collection $product): void;


}
