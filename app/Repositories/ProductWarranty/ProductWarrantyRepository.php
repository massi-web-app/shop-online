<?php

namespace App\Repositories\ProductWarranty;

use App\Models\Brand;
use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductWarrantyRepository implements ProductWarrantyRepositoryInterface
{

    public function save(array $data): ProductWarranty|Model
    {
        return ProductWarranty::query()->create($data);
    }

    public function check_product_warranty_price(array $conditions): Builder
    {
        return ProductWarranty::query()->where($conditions);
    }

    public function list(int $productId): Builder
    {
        return ProductWarranty::query()->with(['getColor','getWarranty'])->where('product_id',$productId)->orderBy('id', 'desc');
    }

    public function trashed(int $productId):Builder
    {
        return ProductWarranty::onlyTrashed();
    }

    public function remove_items(array $warrantyIds)
    {
        $productWarranties = ProductWarranty::query()->withTrashed()->whereIn('id', $warrantyIds)->get();

        foreach ($productWarranties as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
            } else {
                $value->forceDelete();
            }
        }

    }

    public function restore_items(array $warrantyIds)
    {
        $productWarranties = ProductWarranty::query()->onlyTrashed()->whereIn('id', $warrantyIds)->get();
        foreach ($productWarranties as $key => $value) {
            $value->restore();
        }
    }

}
