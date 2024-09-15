<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\CollectionController;
use Modules\Admin\Http\Controllers\CustomerController;
use Modules\Admin\Http\Controllers\DiscountController;
use Modules\Admin\Http\Controllers\GiftCardController;
use Modules\Admin\Http\Controllers\OrderController;
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

Route::group(['prefix' => '/myadmin',  'middleware' => 'auth:admin'], function () {


    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    # Product routes
    Route::resource('/products', ProductController::class)->names('products');
    Route::get('/product-ajax', [ProductController::class, 'productAjax'])->name('products.indexAjax');
    Route::post('/product-bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::get('/search-products', [ProductController::class, 'search'])->name('products.search');

    # Collection routes 
    Route::resource('/collections', CollectionController::class)->names('collections');
    Route::get('/collection-ajax', [CollectionController::class, 'collectionAjax'])->name('collections.indexAjax');
    Route::post('/collection-bulk-delete', [CollectionController::class, 'bulkDelete'])->name('collections.bulkDelete');
    Route::get('/search-collections', [CollectionController::class, 'search'])->name('collections.search');

    #customers routes
    Route::resource('/customers', CustomerController::class)->names('customers');
    Route::get('/customer-ajax', [CustomerController::class, 'indexAjax'])->name('customers.indexAjax');
    Route::post('/customer-bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customers.bulkDelete');
    Route::get('/search-customers', [CustomerController::class, 'search'])->name('customers.search');


    #orders routes
    Route::resource('/orders', OrderController::class)->names('orders');

    #discount 
    Route::resource('/discounts', DiscountController::class)->names('discounts');
    Route::get('/discount-ajax', [DiscountController::class, 'indexAjax'])->name('discounts.indexAjax');
    Route::post('/discount-bulk-delete', [DiscountController::class, 'bulkDelete'])->name('discounts.bulkDelete');
    Route::get('/search-discounts', [DiscountController::class, 'search'])->name('discounts.search');
    Route::get('/get-lists', [DiscountController::class, 'getLists'])->name('discounts.getLists');


    #gift cards
    Route::resource('/gift-cards', GiftCardController::class)->names('giftcards');
    Route::get('/gift-card-ajax', [GiftCardController::class, 'indexAjax'])->name('giftcards.indexAjax');
    Route::post('/gift-card-bulk-delete', [GiftCardController::class, 'bulkDelete'])->name('giftcards.bulkDelete');
    Route::get('/search-giftcards', [GiftCardController::class, 'search'])->name('giftcards.search');
});
