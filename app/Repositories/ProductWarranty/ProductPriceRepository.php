<?php

namespace App\Repositories\ProductWarranty;

use App\Helper\Helper;
use App\Lib\Jdf;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductWarranty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductPriceRepository implements ProductPriceRepositoryInterface
{

    public function add_min_product_price(Model|Collection|ProductWarranty $productWarranty)
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
            if ($productWarranty->sale_product_price < $check_product_price->price  || $check_product_price->price==0) {
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

    public function update_product_price(Model|Collection|Product $product): Product
    {
        $productWarranty = ProductWarranty::query()->where('product_id', $product->id)
            ->where('product_number', '>', 0)->orderBy('sale_product_price', 'ASC')->first();

        if ($productWarranty) {
            $product->price = $productWarranty->sale_product_price;
            $product->status = 1;
            $product->save();
            return $product;
        }
        $product->status = 0;
        $product->save();
        return $product;
    }

    public function check_update_price_today(ProductWarranty $productWarranty)
    {
        $jdf = new Jdf();
        $year = $jdf->tr_num($jdf->jdate('Y'));
        $month = $jdf->tr_num($jdf->jdate('m'));
        $day = $jdf->tr_num($jdf->jdate('j'));

        $row = ProductWarranty::query()->where([
            'product_id' => $productWarranty->product_id,
            'color_id' => $productWarranty->color_id
        ])->where('product_number','>',0)
            ->orderBy('sale_product_price','ASC')->first();

        $price=$row ? $row->sale_product_price : 0;

        $product_price_row = ProductPrice::query()->where([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'color_id' => $productWarranty->color_id,
            'product_id' => $productWarranty->product_id
        ])->first();

        if ($product_price_row) {
            $product_price_row->price = $price;
            $product_price_row->update();
            return $product_price_row;
        }
        return ProductPrice::query()->insert([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'color_id' => $productWarranty->color_id,
            'product_id' => $productWarranty->product_id,
            'price' => $productWarranty->sale_product_price,
            'time' => time(),
            'warranty_id' => $productWarranty->warranty_id,
        ]);
    }


}
