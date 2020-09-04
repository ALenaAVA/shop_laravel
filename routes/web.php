<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@index')->name('index');

Route::get('/categories','MainController@categories')->name('categories');
Route::get('/basket','BasketController@basket')->name('basket');
Route::get('/basket/place','BasketController@basketPlace')->name('basket_place');
Route::post('/basket/confirm','BasketController@basketConfirm')->name('basket_confirm');
Route::post('/basket/add/{id}','BasketController@basketAdd')->name('basket_add');
Route::post('/basket/remove/{id}','BasketController@basketRemove')->name('basket_remove');

Route::get('/{category}','MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
