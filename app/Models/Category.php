<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //region model configs
    use HasFactory,SoftDeletes;

    protected $table = 'categories';
    protected $fillable = ['title', 'ename', 'parent_id', 'img', 'notShow', 'search_url'];

    private static $categoryIds = [null => 'دسته اصلی'];

    //endregion


    //region model relations


    public static function getChildAndCategories(): array
    {
        $categories = [null => 'دسته اصلی'];

        $list_categories = Category::query()->with('getChild.getChild')->whereNull('parent_id')->get();

        self::getListChild($list_categories);

        return self::$categoryIds;
    }


    public function getChild(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public static function getListChild($categories): void
    {
        foreach ($categories as $key => $category) {
            self::$categoryIds[$category->id] = $category->title;
            if (!empty($category->getChild)) {
                self::getListChild($category->getChild);
            }
        }
    }

    public function getParent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
                ->withTrashed()
                ->withDefault(['title' => '-']);
    }
    //endregion


    //region model methods

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($prent_category){
            foreach ($prent_category->getChild()->withTrashed()->get() as $category){
                    if ($category->deleted_at===null){
                        $category->delete();
                    }else{
                        $category->forceDelete();
                    }
            }
        });

        static::restoring(function ($prent_category){
            foreach ($prent_category->getChild()->withTrashed()->get() as $category){
               $category->restore();
            }
        });
    }
    //endregion

}
