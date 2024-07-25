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

    private ProductPriceRepository $productPriceRepository;

    public function __construct(ProductPriceRepository $productPriceRepository)
    {
        $this->productPriceRepository = $productPriceRepository;
    }



    public function add_min_product_price(ProductWarranty|Model|Collection $productWarranty)
    {
        $jdf = Helper::date();
        $year = $jdf->tr_num($jdf->jdate('Y'));
        $month = $jdf->tr_num($jdf->jdate('m'));
        $day = $jdf->tr_num($jdf->jdate('j'));
        $check_product_price = DB::table('product_price')->where([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'color_id' => $productWarranty->color_id,
            'product_id' => $productWarranty->product_id
        ])->first();

        if ($check_product_price) {
            if ($productWarranty->sale_product_price < $check_product_price->price) {
                DB::table('product_price')->where([
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'color_id' => $productWarranty->color_id,
                    'product_id' => $productWarranty->product_id
                ])->update([
                    'price' => $productWarranty->sale_product_price,
                    'warranty_id' => $productWarranty->warranty_id
                ]);
            }
            return;
        }
        DB::table('product_price')->insert([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'color_id' => $productWarranty->color_id,
            'product_id' => $productWarranty->product_id,
            'price' => $productWarranty->sale_product_price,
            'time' => time(),
            'warranty_id' => $productWarranty->warranty_id,
        ]);
        return;
    }

    public function update_product_price(Model|Collection|Builder $product)
    {
        $this->productPriceRepository->update_product_price($product);
    }

}
