<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    //region model configs
    use HasFactory,SoftDeletes;

    protected $table='colors';
    protected $fillable=['name','code'];

    //endregion
}
