<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    //region model configs
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $fillable = ['title', 'ename', 'brand_id', 'category_id', 'image_url', 'special', 'price', 'view', 'show',
        'discount_price', 'summery', 'description', 'keywords', 'product_url'];

    //endregion model config

    //region model methods
    public static function productStatus()
    {
        $array = array();
        $array[-3] = 'رد شده';
        $array[-2] = 'درانتظار بررسی';
        $array[-1] = 'توقف تولید';
        $array[0] = 'ناموجود';
        $array[1] = 'منتشر شده';
        return $array;
    }


    //endregion model methods


    //region relations
    public function productColors()
    {
        return $this->hasManyThrough(Color::class,ProductColor::class,'id','id','product_id','color_id');

    }
    //endregion relations
}
