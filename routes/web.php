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

Route::prefix('/admin')->group(function (){


    Route::get('/',[
        \App\Http\Controllers\Admin\AdminController::class,
        'index'
    ])->name('admin.index');

    /**
     * Route Categories
     */
    Route::resource('category',\App\Http\Controllers\Admin\CategoryController::class)
        ->except(['show']);

});





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
