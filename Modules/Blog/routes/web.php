<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\CategoryController;

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

Route::group(['prefix' => '/myadmin',  'middleware' => ['auth:admin', 'checkPermission']], function () {
    Route::resource('blog', BlogController::class)->names('blogs');
    Route::get('blogs-ajax', [BlogController::class, 'indexAjax'])->name('blogs.indexAjax');
    //bulk delete 
    Route::post('blogs-bulk-delete', [BlogController::class, 'bulkDelete'])->name('blogs.bulkDelete');

    Route::resource('blog-category', CategoryController::class)->names('blogcategory');
    Route::get('blog-category-ajax', [CategoryController::class, 'indexAjax'])->name('blogcategory.indexAjax');
    //bulk delete 
    Route::post('blog-category-bulk-delete', [CategoryController::class, 'bulkDelete'])->name('blogcategory.bulkDelete');
    
});
