<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    //region model config
    use HasFactory,SoftDeletes;

    protected $table='brands';
    protected $fillable=['name','ename','icon','description'];
    //endregion


    //region  model methods

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($brand){
            if ($brand->isForceDeleting()){
                if (!empty($brand->icon) && file_exists('files/upload/'.$brand->icon)){
                    unlink('files/upload/'.$brand->icon);
                }
            }
        });
    }
    //endregion
}
