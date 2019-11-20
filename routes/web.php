<?php

//Guest
Route::any('/{url}', 'Shop\MainController@index' )->where('url', '(home|)')
    ->name('shop.home');
Route::get('/product/{alias}', 'Shop\MainController@getProduct')->name('shop.getproduct');
Route::get('/category/{alias}', 'Shop\MainController@getCategory')->name('shop.getcategory');
Route::get('/autocomplete', 'Shop\SearchController@search');
Route::get('/search/result', 'Shop\SearchController@index');
//User Routes
Route::group(['middleware' => ['auth']], function () {
    $groupData = [
        'namespace' => 'Shop\User',
    ];
    Route::group($groupData, function () {
        Route::get( '/cart', 'UserController@index')->name('cart');
        Route::get('/changePassword','UserController@showChangePasswordForm');
        Route::get('/cart/delete/{id}', 'UserController@destroy')->name('shop.user.delProd');
        Route::post('/cart/save/{id}','UserController@update')->name('shop.user.saveOrder');
        Route::post('/product/{id}', 'UserController@addOrder')->name('shop.user.addOrder');
    });
});
//Auth
Auth::routes();

//Admin Panel rotes group **Only for admins//
Route::group(['middleware' => ['status', 'auth']], function () {
    $groupData = [
        'namespace' => 'Shop\Admin',
        'prefix' => 'admin',
    ];

    Route::group($groupData, function () {
        //Main page
        Route::resource('index', 'MainController')->names('shop.admin.index');


        ///ORDERS////
        Route::resource('orders', 'OrderController')->names('shop.admin.orders');
        Route::get('/orders/change/{id}', 'OrderController@change')
            ->name('shop.admin.orders.change');
        Route::post('/orders/save/{id}', 'OrderController@save')
            ->name('shop.admin.orders.save');
        Route::get('/orders/forcedelete/{id}', 'OrderController@forcedelete')
            ->name('shop.admin.orders.forcedelete');
        Route::get('/orders/restore/{id}', 'OrderController@restore')
            ->name('shop.admin.orders.restore');
        ///CATEGORY////
        Route::resource('categories', 'CategoryController')
            ->names('shop.admin.categories');
        Route::get('categories.mdel', 'CategoryController@mdel')
            ->name('shop.admin.categories.mdel');
        ///USERS///
        Route::resource('users', 'UserController')->names('shop.admin.users');
        ///PRODUCTS////
        Route::get('/products/related', 'ProductController@related');
        Route::resource('products', 'ProductController')->names('shop.admin.products');
        Route::get('products/create/step-1', 'ProductController@createStep1')
            ->name('shop.admin.products.createStep1');
        Route::post('products/create/step-2','ProductController@createStep2')
            ->name('shop.admin.products.createStep2');
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
        ///FILTERS////
        ///     GROUP
        Route::get('/filter/group-filter','FilterController@attributeGroup')
            ->name('shop.admin.filter.group-filter');
        Route::match(['get','post'],'/filter/group-add', 'FilterController@groupAdd');
        Route::match(['get','post'],'/filter/group-edit/{id}','FilterController@groupEdit');
        Route::get('/filter/group-delete/{id}','FilterController@groupDelete')
            ->name('shop.admin.filter.group-delete');
        ///     ATTRIBUTE
        Route::get('/filter/attribute-filter','FilterController@attributeFilter')
            ->name('shop.admin.filter.attribute-filter');
        Route::match(['get','post'],'/filter/attr-add', 'FilterController@attributeAdd');
        Route::match(['get','post'],'/filter/attr-edit/{id}', 'FilterController@attrEdit');
        Route::get('/filter/attr-delete/{id}','FilterController@attrDelete');
        /// CURRENCY
        Route::get('/currency/index','CurrencyController@index')
            ->name('shop.admin.currency.index');
        Route::match(['get','post'],'/currency/add', 'CurrencyController@add');
        Route::match(['get','post'],'/currency/edit/{id}', 'CurrencyController@edit');
        Route::get('/currency/delete/{id}','CurrencyController@delete');
        /// SEARCH
        Route::get('/search/result', 'SearchController@index');
        Route::get('/autocomplete', 'SearchController@search');
    });
});


