<?php

namespace App\Repositories\ProductWarranty;

use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Model;

class ProductWarrantyRepository implements ProductWarrantyRepositoryInterface
{

    public function save(array $data): ProductWarranty|Model
    {
        return ProductWarranty::query()->create($data);
    }
}
