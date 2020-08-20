<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@index');

Route::get('/categories','MainController@categories');
Route::get('/{category}','MainController@category');

Route::get('/product/{product?}', 'MainController@product');
