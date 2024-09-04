<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/product-details', 'products.product-details')->name('product-details');
Route::view('/collections', 'pages.collections')->name('collections');
Route::view('/collection', 'pages.collection')->name('collection');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/about-us', 'pages.about')->name('about');