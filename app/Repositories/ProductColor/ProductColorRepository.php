<?php

namespace App\Repositories\ProductColor;

use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductColorRepository implements ProductColorInterface
{

    public function listProductColor(int $productId): Collection
    {
        return ProductColor::with('getColor')->where('product_id', $productId)->get();
    }

}
