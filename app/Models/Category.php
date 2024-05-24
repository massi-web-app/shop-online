<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //region model configs
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['title', 'ename', 'parent_id', 'img', 'notShow', 'search_url'];
    //endregion


    //region model relations


    public static function get_parent():array
    {
        $categories = [0 => 'دسته اصلی'];
        $list_categories = Category::query()->whereNull('parent_id')->get();
        $list_categories = $list_categories->map(function ($category) {
            return $category->id = $category->title;
        });
        return array_merge($categories,$list_categories->toArray());
    }

    //endregion


}
