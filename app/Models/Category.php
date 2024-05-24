<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //region model configs
    use HasFactory;

    protected $table='categories';
    protected $fillable=['title','ename','parent_id','img','notShow','search_url'];
    //endregion


}
