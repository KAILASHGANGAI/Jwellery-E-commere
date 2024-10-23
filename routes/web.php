<?php

use App\Http\Controllers\AddTOCardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('home');

// Route::view('/collection', 'pages.collection')->name('collection');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about-us', 'pages.about')->name('about');
#left pages 
Route::view('/terms-and-conditions', 'pages.extra.terms-and-conditions')->name('terms-and-conditions');
Route::view('/returns-and-exchanges-policy', 'pages.extra.privacy-policy')->name('policy');
Route::view('/faq', 'pages.extra.faq')->name('faq');
Route::view('/my-account', 'pages.profile.my-account')->name('my-account');
Route::view('/my-orders', 'pages.profile.my-orders')->name('my-orders');

Route::get('/nav-collections', [CollectionController::class, 'index'])->name('all-collections');
Route::get('/collections', [CollectionController::class, 'allCollection'])->name('all.collections');
Route::get('/childrens-collections', [CollectionController::class, 'showAllChildrens'])->name('childCollections');
Route::get('/collection/{slug}', [CollectionController::class, 'show'])->name('collections');

Route::get('/products', [ProductController::class, 'index'])->name('all.products');
Route::get('api/products', [ProductController::class, 'ajaxIndex'])->name('web.products');
Route::get('/product-details/{sku}', [ProductController::class, 'show'])->name('product-details');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('auth.register');


// routes/web.php
Route::post('/cart/add', [AddTOCardController::class, 'addToCart'])->name('cart.add');
Route::get('/get-cart-items', [AddTOCardController::class, 'getCart'])->name('cart.get');
Route::get('/cart/{cartId}', [AddTOCardController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/update', [AddTOCardController::class, 'updateCart'])->name('cart.update');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::get('wishlist', [AddTOCardController::class, 'wishlist'])->name('wishlist');
Route::post('/wishlist-products', [AddTOCardController::class, 'getWishlistProducts'])->name('wishlist-products');

// check out 
Route::get('/check-out',[CheckOutController::class, 'index'])->name('checkout');
Route::get('shopping-cart', [CheckOutController::class, 'shipCard'])->name('shopping-cart');
Route::post('/place-order', [CheckOutController::class, 'placeOrder'])->name('place-order');

Route::get('order-success', [CheckOutController::class, 'orderSuccess'])->name('orderSuccess');
Route::get('order-failed', [CheckOutController::class, 'orderFailed'])->name('order-failed');
Route::get('order-cancel', [CheckOutController::class, 'orderCancel'])->name('order-cancel');
Route::get('/download-bill/{orderID}', [CheckOutController::class, 'downloadBill'])->name('download-bill');

#blogs 
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog-category/{slug}', [BlogController::class, 'category'])->name('blog.category');