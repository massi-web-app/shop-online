<?php

namespace App\Repositories\ProductWarranty;

use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ProductWarrantyRepositoryInterface
{
    public function save(array $data): ProductWarranty|Model;

    public function check_product_warranty_price(array $conditions): Builder;

    public function list(int $productId):Builder;

    public function trashed(int $productId):Builder;


}
