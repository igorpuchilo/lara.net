<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Admin//
Route::group(['middleware' => ['status', 'auth']], function () {
    $groupData = [
        'namespace' => 'Shop\Admin',
        'prefix' => 'admin',
    ];

    Route::group($groupData, function () {
        Route::resource('index', 'MainController')->names('shop.admin.index');

        Route::resource('orders', 'OrderController')->names('shop.admin.orders');
        ///ORDERS////
        Route::get('/orders/change/{id}', 'OrderController@change')
            ->name('shop.admin.orders.change');
        Route::post('/orders/save/{id}', 'OrderController@save')
            ->name('shop.admin.orders.save');
        Route::get('/orders/forcedelete/{id}', 'OrderController@forcedelete')
            ->name('shop.admin.orders.forcedelete');
        ///CATEGORY////
        Route::resource('categories', 'CategoryController')
            ->names('shop.admin.categories');
        Route::get('categories.mdel', 'CategoryController@mdel')
            ->name('shop.admin.categories.mdel');

        Route::resource('users', 'UserController')->names('shop.admin.users');

        Route::get('/products/related', 'ProductController@related');
        Route::resource('products', 'ProductController')->names('shop.admin.products');
        Route::match(['get','post'], '/products/ajax-image-upload','ProductController@ajaxImage');
        Route::delete('/products/ajax-remove-image/{filename}','ProductController@deleteImage');
        Route::post('/products/gallery','ProductController@gallery')
            ->name('shop.admin.products.gallery');
        Route::post('/products/delete-gallery','ProductController@deleteGallery')
            ->name('shop.admin.products.deletegallery');
        Route::get('/products/get-status/{id}', 'ProductController@getStatus')
            ->name('shop.admin.products.getstatus');
        Route::get('/products/get-status/{id}', 'ProductController@getStatus')
            ->name('shop.admin.products.getstatus');
        Route::get('/products/delete-status/{id}', 'ProductController@deleteStatus')
            ->name('shop.admin.products.deletestatus');
        Route::get('/products/delete-product/{id}','ProductController@deleteProduct')
            ->name('shop.admin.products.deleteproduct');
    });
});

Route::get('/user/index', 'Shop\User\MainController@index');

