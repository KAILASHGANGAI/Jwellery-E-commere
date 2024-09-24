<?php

use App\Http\Controllers\AddTOCardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('auth.register');


// routes/web.php
Route::post('/cart/add', [AddTOCardController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/{userId}', [AddTOCardController::class, 'getCart'])->name('cart.get');
Route::delete('/cart/{cartId}', [AddTOCardController::class, 'removeItem'])->name('cart.remove');

