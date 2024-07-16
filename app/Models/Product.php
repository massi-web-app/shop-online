<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    //region model configs
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $fillable = ['title', 'ename', 'brand_id', 'category_id', 'image_url', 'special', 'price', 'view', 'show',
        'discount_price', 'summery', 'description', 'keywords', 'product_url','status'];

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
        return $this->hasManyThrough(Color::class,ProductColor::class,'product_id','id','id','color_id');
    }
    //endregion relations

    //region mutator


    public function getProductStatusAttribute()
    {
        $list_status=self::productStatus();
        if (array_key_exists($this->status,$list_status)) {
            return $list_status[$this->status];
        }
        return null;

    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product){
            if ($product->isForceDeleting()){
                Helper::removeFile('files/products',$product);

            }
        });

    }
    //endregion
}
