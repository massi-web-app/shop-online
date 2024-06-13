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
    protected $fillable = ['title','ename','brand_id','category_id','image_url', 'special','price','view','show',
        'discount_price','summery','description','keywords','product_url'];
}
