<?php

namespace App\Repositories\ProductWarranty;

use App\Models\Product;
use App\Models\ProductWarranty;
use App\Services\Product\Service\ProductService;
use App\Services\ProductWarranty\ProductPriceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductWarrantyRepository implements ProductWarrantyRepositoryInterface
{

    private ProductPriceService $productPriceService;

    public function __construct(ProductPriceService $productPriceService)
    {

        $this->productPriceService = $productPriceService;
    }

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
        return ProductWarranty::query()->with(['getColor', 'getWarranty'])->where('product_id', $productId)->orderBy('id', 'desc');
    }

    public function trashed(int $productId): Builder
    {
        return ProductWarranty::onlyTrashed();
    }

    public function remove_items(array $warrantyIds, Product $product)
    {
        $productWarranties = ProductWarranty::query()->withTrashed()->whereIn('id', $warrantyIds)->get();

        foreach ($productWarranties as $key => $value) {
            if ($value->deleted_at === null) {
                $value->delete();
                $this->productPriceService->check_price_today($value);
                $this->productPriceService->update_product_price($product);
            } else {
                $value->forceDelete();
            }

        }

    }

    public function restore_items(array $warrantyIds, Product $product)
    {
        $productWarranties = ProductWarranty::query()->onlyTrashed()->whereIn('id', $warrantyIds)->get();
        foreach ($productWarranties as $key => $productWarranty) {
            $productWarranty->restore();
            $this->productPriceService->add_min_product_price($productWarranty);
            $this->productPriceService->update_product_price($product);
        }
    }

    public function check_has_product_warranty(ProductWarranty $productWarranty)
    {
        $row = ProductWarranty::query()->where([
            'product_id' => $productWarranty->product_id,
            'color_id' => $productWarranty->color_id
        ])->where('product_number', '>', 0)->orderBy('sale_product_price', 'ASC')->first();

        $price = $row ? $row->sale_product_price : 0;
        $warrantyId = $row ? $row->warrantyId : 0;
        $this->productPriceService->check_price_today($productWarranty, $price, $warrantyId);
    }

    public function delete(int $product_Warranty_id): Model|array|\Illuminate\Database\Eloquent\Collection|Builder|bool|\Illuminate\Database\Query\Builder|null
    {
        $productWarranty = ProductWarranty::withTrashed()->findOrFail($product_Warranty_id);
        if ($productWarranty->deleted_at === null) {
            $productWarranty->delete();
            return $productWarranty;
        }
        $productWarranty->forceDelete();


        return false;


    }

    public function restore(int $productWarrantyId)
    {
        $productWarranty = ProductWarranty::onlyTrashed()->findOrFail($productWarrantyId);
        $productWarranty->restore();
        return $productWarranty;
    }

}
