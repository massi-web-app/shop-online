<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    //region model config
    use HasFactory;
    protected $table='item_value';
    protected $fillable=['product_id','item_id','value'];
    //endregion model config
}
