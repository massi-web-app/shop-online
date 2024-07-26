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

    \App\Helper\Helper::generateCrudUrl('category',\App\Http\Controllers\Admin\CategoryController::class);

    //endregion route categories

    //region route brands

    \App\Helper\Helper::generateCrudUrl('brand',\App\Http\Controllers\Admin\BrandController::class);
    //endregion route categories

    //region route colors
    \App\Helper\Helper::generateCrudUrl('color',\App\Http\Controllers\Admin\ColorController::class);
    //endregion route categories

    //region route products
    \App\Helper\Helper::generateCrudUrl('product',
        \App\Http\Controllers\Admin\ProductController::class,true);
    //endregion route categories

    //region route warranties
    \App\Helper\Helper::generateCrudUrl('warranty',\App\Http\Controllers\Admin\WarrantyController::class);
    //endregion route categories

    //region route product warranty
    \App\Helper\Helper::generateCrudUrl('product_warranties',\App\Http\Controllers\Admin\ProductWarrantyController::class);
    //endregion route categories


    Route::get('/product/gallery/{id}',[
        \App\Http\Controllers\Admin\ProductController::class,
        'gallery'
    ])->name('product.gallery');

    Route::post('/product/gallery/upload/{id}',[
        \App\Http\Controllers\Admin\ProductController::class,
        'gallerySave'
    ])->name('product.gallery.upload');

    Route::delete('/product/gallery/upload/{id}',[
        \App\Http\Controllers\Admin\ProductController::class,
        'removeImageFromGallery'
    ])->name('product.gallery.remove');


});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
