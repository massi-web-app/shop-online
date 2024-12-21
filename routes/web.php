<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->group(function () {


    Route::get('/', [
        \App\Http\Controllers\Admin\AdminController::class,
        'index'
    ])->name('admin.index');

    //region route categories

    \App\Helper\Helper::generateCrudUrl('category', \App\Http\Controllers\Admin\CategoryController::class);

    Route::get('/category/{id}/items',[\App\Http\Controllers\Admin\ItemController::class,'items'])->name('category.items');

    Route::post('/category/{id}/items',[\App\Http\Controllers\Admin\ItemController::class,'add_item'])->name('category.items.add_item');

    Route::delete('/category/remove_items/{id}',[\App\Http\Controllers\Admin\ItemController::class,'remove_item'])->name('category.items.remove_item');

    //endregion


    //region route brands

    \App\Helper\Helper::generateCrudUrl('brand', \App\Http\Controllers\Admin\BrandController::class);
    //endregion route categories

    //region route colors
    \App\Helper\Helper::generateCrudUrl('color', \App\Http\Controllers\Admin\ColorController::class);
    //endregion route categories

    //region route products
    \App\Helper\Helper::generateCrudUrl('products',
        \App\Http\Controllers\Admin\ProductController::class, true);

    Route::get('/products/{id}/items',[\App\Http\Controllers\Admin\ProductController::class,'items'])->name('products.show.items');


    Route::post('/products/{id}/items',[\App\Http\Controllers\Admin\ProductController::class,'add_items'])->name('products.add.items');

    Route::get('/products/{id}/filters',[\App\Http\Controllers\Admin\ProductController::class,'filters'])->name('products.show.filters');


    Route::post('/products/{id}/filters',[\App\Http\Controllers\Admin\ProductController::class,'add_filters'])->name('products.add.filters');


    //endregion route categories

    //region route warranties
    \App\Helper\Helper::generateCrudUrl('warranty', \App\Http\Controllers\Admin\WarrantyController::class);
    //endregion route categories

    //region route product warranty
    \App\Helper\Helper::generateCrudUrl('product_warranties', \App\Http\Controllers\Admin\ProductWarrantyController::class);
    //endregion route categories

    //region route for sliders
    \App\Helper\Helper::generateCrudUrl('sliders',\App\Http\Controllers\Admin\SliderController::class);
    //endregion

    //region route for galleries
    Route::get('/product/gallery/{id}', [
        \App\Http\Controllers\Admin\ProductController::class,
        'gallery'
    ])->name('product.gallery');

    Route::post('/product/gallery/upload/{id}', [
        \App\Http\Controllers\Admin\ProductController::class,
        'gallerySave'
    ])->name('product.gallery.upload');

    Route::delete('/product/gallery/upload/{id}', [
        \App\Http\Controllers\Admin\ProductController::class,
        'removeImageFromGallery'
    ])->name('product.gallery.remove');

    Route::post('/product/gallery/sort/{id}',[
        \App\Http\Controllers\Admin\ProductController::class,
        'sortImage',
    ])->name('product.gallery.sort');

    //endregion

    //region route for filters

    Route::get('/category/{id}/filters',[\App\Http\Controllers\Admin\FilterController::class,'filters'])->name('category.filters');

    Route::post('/category/{id}/filters',[\App\Http\Controllers\Admin\FilterController::class,'add_filter'])->name('category.filters.add_item');

    Route::delete('/category/remove_filters/{id}',[\App\Http\Controllers\Admin\FilterController::class,'remove_filter'])->name('category.filters.remove_item');

    //endregion


});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
