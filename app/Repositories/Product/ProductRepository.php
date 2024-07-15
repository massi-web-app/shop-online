<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{

    public function list(string $trashed = null)
    {
        return Product::query()->orderBy('id', 'desc');
    }

    public function store(array $data): Model
    {
        $product = Product::query()->create($data);

        //todo:refactor set the product color
        foreach ($data['product_color_id'] as $color_id){
            ProductColor::query()->create([
                'color_id'=>$color_id,
                'product_id'=>$product->id,
                'category_id'=>$product->category_id
            ]);
        }
        return $product;
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

    public function trashed(): array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        return Category::onlyTrashed()->get();
    }

    public function restore(Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null $category): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
    {
        // TODO: Implement restore() method.
    }

    public function getStatus(): array
    {
        return Product::productStatus();
    }
}
