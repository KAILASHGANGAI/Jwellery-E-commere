<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;

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

Route::group(['prefix' => '/myadmin',  'middleware' => 'auth:admin'], function () {
    Route::resource('blog', BlogController::class)->names('blogs');
    Route::get('blogs-ajax', [BlogController::class, 'indexAjax'])->name('blogs.indexAjax');
    //bulk delete 
    Route::post('blogs-bulk-delete', [BlogController::class, 'bulkDelete'])->name('blogs.bulkDelete');

});
