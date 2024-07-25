<?php

namespace App\Repositories\ProductWarranty;

use App\Models\Product;
use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductPriceRepositoryInterface
{
    public function add_min_product_price(Model|ProductWarranty|Collection $productWarranty): ProductWarranty;

    public function update_product_price(Model|Product|Collection $product): Product;
}
