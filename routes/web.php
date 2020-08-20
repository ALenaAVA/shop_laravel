<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@index');

Route::get('/categories','MainContoller@categories');

Route::get('/product/iphone_x_64', 'MainController@product');
