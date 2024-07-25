<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{

    public function list(string $trashed = null)
    {
        return Product::query()->orderBy('id', 'desc');
    }

    public function store(array $data): Model
    {
        return Product::query()->create($data);
    }

    public function find(int $id)
    {
        return Product::query()->findOrFail($id);
    }

    public function update(Product|Model $product, array $data): Product|Model
    {
        $product->update($data);
        return $product;
    }

    public function updateProductColors(Model|Product $product, array $colors): void
    {
        ProductColor::query()->where('product_id', $product->id)->delete();
        foreach ($colors as $color_id) {
            ProductColor::query()->create([
                'color_id' => $color_id,
                'product_id' => $product->id,
                'category_id' => $product->category_id
            ]);
        }
    }

    public function trashed(): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return Product::onlyTrashed()->get();
    }

    public function withTrashed(int $id)
    {
        return Product::query()->withTrashed()->findOrFail($id);
    }


    public function getStatus(): array
    {
        return Product::productStatus();
    }

    public function delete(int $productId): bool
    {
        $product = $this->withTrashed($productId);
        if ($product->deleted_at === null) {
            $product->delete();
            return true;
        }
        $product->forceDelete();
        return true;
    }


    public function restore(int $productId): void
    {
        $product = $this->withTrashed($productId);
        $product->restore();
    }

    public function remove_items(array $productIds): void
    {
        $product = Product::query()->withTrashed()->whereIn('id', $productIds)->get();

        foreach ($product as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }

    }

    public function restore_items(array $productIds): void
    {
        $brands = Product::query()->onlyTrashed()->whereIn('id', $productIds)->get();
        foreach ($brands as $key => $value) {
            $value->restore();
        }
    }

    public function update_product_price(Model|Collection|Product $product): void
    {

    }
}
