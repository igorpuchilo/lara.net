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

    });
});

Route::get('/user/index','Shop\User\MainController@index');

