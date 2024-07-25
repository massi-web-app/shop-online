<?php

namespace App\Repositories\ProductWarranty;

use App\Models\Product;
use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductPriceRepository implements ProductPriceRepositoryInterface
{

    public function add_min_product_price(Model|Collection|ProductWarranty $productWarranty): ProductWarranty
    {
        // TODO: Implement add_min_product_price() method.
    }

    public function update_product_price(Model|Collection|Product $product): Product
    {
        $productWarranty = ProductWarranty::query()->where('product_id', $product->id)
            ->where('product_number', '>', 0)->orderBy('sale_product_price', 'ASC')->first();

        if ($productWarranty) {
            $product->price = $productWarranty->sale_product_price;
            $product->status = 1;
            $product->save();
            return $product;
        }
        $product->status = 0;
        $product->save();
        return $product;
    }
}
