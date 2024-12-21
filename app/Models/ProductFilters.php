<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFilters extends Model
{
    //region model config
    use HasFactory;

    protected $table='product_filters';
    protected $fillable=['product_id','filter_id','filter_value'];

    //endregion
}
