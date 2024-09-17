<?php

use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/product-details', 'products.product-details')->name('product-details');
Route::view('/collection', 'pages.collection')->name('collection');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about-us', 'pages.about')->name('about');

Route::get('all-collections',[CollectionController::class, 'index'])->name('all-collections');
Route::get('/collection/{slug}', [CollectionController::class, 'show'])->name('collections');

