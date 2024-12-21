<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{

    //region model config
    use HasFactory;
    protected $table='filters';
    protected $fillable=['category_id','position','item_id','parent_id'];
    //endregion

    //region model relations

    public function getChild()
    {
        return $this->hasMany(Filter::class,'parent_id','id')
            ->orderBy('position','ASC');
    }

    public function getValue()
    {
        return $this->hasMany(ProductFilters::class,'filter_id','id')
            ->where('product_id',product_id);
    }

    //endregion


}
