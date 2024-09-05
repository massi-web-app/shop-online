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

    //endregion


}
