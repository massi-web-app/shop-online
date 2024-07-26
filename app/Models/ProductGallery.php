<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    //region model config
    use HasFactory;

    protected $table='product_galleries';
    protected $fillable=['product_id','position','image_url'];
    //region model config
}
