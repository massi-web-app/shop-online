<?php

namespace App\Services\ProductWarranty;

use App\Helper\Helper;
use App\Models\ProductWarranty;
use App\Repositories\ProductWarranty\ProductPriceRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductPriceService
{

    public ProductPriceRepository $productPriceRepository;
    public ProductWarrantyService $productWarrantyService;

    public function __construct(ProductPriceRepository $productPriceRepository)
    {
        $this->productPriceRepository = $productPriceRepository;
    }


    public function add_min_product_price(ProductWarranty|Model|Collection $productWarranty)
    {
        $this->productPriceRepository->add_min_product_price($productWarranty);
    }

    public function update_product_price(Model|Collection|Builder $product)
    {
        $this->productPriceRepository->update_product_price($product);
    }

    public function check_price_today(ProductWarranty $productWarranty)
    {
        return $this->productPriceRepository->check_update_price_today($productWarranty);
    }

}
