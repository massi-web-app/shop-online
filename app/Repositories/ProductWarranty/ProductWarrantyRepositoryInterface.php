<?php

namespace App\Repositories\ProductWarranty;

use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Model;

interface ProductWarrantyRepositoryInterface
{
    public function save(array $data): ProductWarranty|Model;


}
