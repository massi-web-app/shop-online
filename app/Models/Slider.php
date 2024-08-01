<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //region model config
    use HasFactory,SoftDeletes;

    protected $table='sliders';
    protected $fillable=['title','image_url','url','mobile_image_url'];
    //endregion

    public static function boot()
    {
        parent::boot();
       static::deleted(function ($slider){
           if ($slider->isForceDeleting()){
               Helper::removeFile('files/slider',$slider->image_url);
               if ($slider->mobile_image_url!==null){
                   Helper::removeFile('files/slider',$slider->mobile_image_url);
               }
           }

       });
    }
}
