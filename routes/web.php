<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/collection', 'pages.collection')->name('collection');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about-us', 'pages.about')->name('about');

Route::get('/all-collections',[CollectionController::class, 'index'])->name('all-collections');
Route::get('/childrens-collections',[CollectionController::class, 'showAllChildrens'])->name('childCollections');
Route::get('/collection/{slug}', [CollectionController::class, 'show'])->name('collections');

Route::get('products', [ProductController::class, 'index'])->name('web.products');
Route::get('/product-details/{sku}', [ProductController::class, 'show'])->name('product-details');


// routes/web.php
Route::post('/cart/add', [ProductController::class, 'add'])->name('cart.add');

