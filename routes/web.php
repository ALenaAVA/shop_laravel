<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@index')->name('index');

Route::get('/categories','MainController@categories')->name('categories');
Route::get('/basket','MainController@basket')->name('basket');
Route::get('/basket/place','MainController@basketPlace')->name('basket_place');
Route::get('/{category}','MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');
