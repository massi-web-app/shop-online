<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    //region model config
    use HasFactory;

    protected $table='items';
    protected $fillable=['category_id','title','position','item_important','parent_id'];
    //endregion


}
