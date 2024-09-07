<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\CollectionController;
use Modules\Admin\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([ 'prefix' => 'admin'], function () {
    Route::resource('/dashboard', AdminController::class)->names('admin');
    Route::resource('/products', ProductController::class)->names('products');
    Route::resource('/collections', CollectionController::class)->names('collections');
    Route::get('/collection-ajax', [CollectionController::class, 'collectionAjax'])->name('collections.indexAjax');
});
