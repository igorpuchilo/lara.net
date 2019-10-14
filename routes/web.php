<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


            //Admin//
Route::group(['middleware'=> ['status','auth']], function (){
   $groupData = [
       'namespace' => 'Shop\Admin',
       'prefix' => 'admin',
   ];

    Route::group($groupData, function (){
        Route::resource('index', 'MainController')->names('shop.admin.index');

        Route::resource('orders', 'OrderController')->names('shop.admin.orders');
        ///ORDERS////
        Route::get('/orders/change/{id}', 'OrderController@change')
            ->name('shop.admin.orders.change');
        Route::post('/orders/save/{id}','OrderController@save')
            ->name('shop.admin.orders.save');
        Route::get('/orders/forcedelete/{id}','OrderController@forcedelete')
            ->name('shop.admin.orders.forcedelete');
        ///CATEGORY////
        Route::resource('categories', 'CategoryController')
            ->names('shop.admin.categories');
        Route::get('categories.mdel','CategoryController@mdel')
            ->name('shop.admin.categories.mdel');
    });
});

Route::get('/user/index','Shop\User\MainController@index');

