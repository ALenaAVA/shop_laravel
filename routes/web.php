<?php
Auth::routes();

Route::get('/', 'MainController@index')->name('index');

Route::group(['middleware'=>'auth',
    'namespace'=>'Admin',
    'prefix'=>'admin'
    ],function (){
    Route::group(['middleware'=>'is_admin'],function (){
        Route::get('/orders', 'HomeController@index')->name('home');
    });
    Route::resource('categories','CategoryController');
});

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/categories','MainController@categories')->name('categories');
Route::group(['middleware'=>'basket_not_empty',
                'prefix'=>'basket'],function (){
    Route::get('','BasketController@basket')->name('basket');
    Route::get('/place','BasketController@basketPlace')->name('basket_place');
    Route::post('/confirm','BasketController@basketConfirm')->name('basket_confirm');
    Route::post('/add/{id}','BasketController@basketAdd')->name('basket_add');
    Route::post('/remove/{id}','BasketController@basketRemove')->name('basket_remove');
});
Route::post('/basket/add/{id}','BasketController@basketAdd')->name('basket_add');


Route::get('/{category}','MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');
