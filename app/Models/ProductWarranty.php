<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWarranty extends Model
{
    //region model config
    use HasFactory,SoftDeletes;

    protected $table='product_warranties';
    protected $fillable=['product_id','color_id','warranty_id','seller_id','send_time','real_product_price','sale_product_price','product_number','product_number_cart'];
    //endregion
}
