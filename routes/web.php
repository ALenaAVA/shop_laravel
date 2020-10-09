<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/reset','ResetController@reset')->name('reset_db');
Route::get('/', 'MainController@index')->name('index');
//Route::middleware(['auth'])->group(function (){
    Route::group([
        'namespace'=>'Person',
        'prefix'=>'person'
    ], function (){
        Route::get('/orders', 'OrderController@index')->name('orders.index');
        Route::get('/orders/{order}', 'OrderController@show')->name('person.orders.show');
    });

    Route::group([
        'namespace'=>'Admin',
        'prefix'=>'admin'
    ],function (){
        Route::group(['middleware'=>'is_admin'],function (){
            Route::get('/orders', 'HomeController@index')->name('home');
            Route::get('/orders/{order}', 'HomeController@show')->name('orders.show');
        });
        Route::resource('categories','CategoryController');
        Route::resource('products','ProductController');
    });
//});


Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/categories','MainController@categories')->name('categories');
Route::group(['middleware'=>'basket_not_empty',
                'prefix'=>'basket'],function (){
    Route::get('','BasketController@basket')->name('basket');
    Route::get('/place','BasketController@basketPlace')->name('basket_place');
    Route::post('/confirm','BasketController@basketConfirm')->name('basket_confirm');
    Route::post('/add/{product}','BasketController@basketAdd')->name('basket_add');
    Route::post('/remove/{product}','BasketController@basketRemove')->name('basket_remove');
});
Route::post('/basket/add/{product}','BasketController@basketAdd')->name('basket_add');


Route::get('/{category}','MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');
