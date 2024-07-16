<?php

namespace App\Repositories\ProductColor;

use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductColorInterface
{
    public function listProductColor(int $productId): Collection;

}
