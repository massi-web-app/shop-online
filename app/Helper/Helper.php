<?php

namespace App\Helper;

use App\Lib\Jdf;
use Illuminate\Support\Facades\Route;
use Spatie\Image\Image;

class Helper
{
    public static function generateQueryString(string $queryString, string $text): string
    {
        if ($queryString == '?') {
            return $queryString . $text;
        }
        return $queryString . '&' . $text;
    }

    public static function date()
    {
        return new Jdf();

    }


    public static function generateCrudUrl($name_route,$controller,$show=false):void
    {
        Route::post($name_route.'/remove_items',[$controller,'removeItems']);
        Route::post($name_route.'/restore_items',[$controller,'restoreItems']);
        Route::post($name_route.'/{category}',[$controller,'restore']);
        if ($show){
            Route::resource($name_route, $controller);
            return;
        }
        Route::resource($name_route, $controller)->except(['show']);

    }

    public static function fit_image($image_url,$image_name)
    {
        Image::load($image_url)
            ->width(300)
            ->height(300)
            ->save('/files/thumbnails/'.$image_name);

    }

}
