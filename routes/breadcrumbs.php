<?php

// Home
Breadcrumbs::for('Home', function ($trail) {
    $trail->parent('Back');
    $trail->push('Home', url('/home'));
});
//Back
Breadcrumbs::for('Back', function ($trail) {
    $trail->push('Back', url()->previous());
});
// Home > Cart
Breadcrumbs::for('Cart', function ($trail) {
    $trail->parent('Home');
    $trail->push('Cart', route('shop.cart'));
});
Breadcrumbs::for('Profile', function ($trail) {
    $trail->parent('Home');
    $trail->push('Profile Edit', route('shop.user.edit'));
});
// Home > Order History
Breadcrumbs::for('Order', function ($trail) {
    $trail->parent('Home');
    $trail->push('Order History', route('shop.orderHistory'));
});
// Home > Search
Breadcrumbs::for('Search', function ($trail,$query) {
    $trail->parent('Home');
    $trail->push('Search: "'.$query.'"');
});
// Home > Category
Breadcrumbs::for('Category', function ($trail, $category) {
    $trail->parent('Home');
    $trail->push($category->title);
});
//Category
Breadcrumbs::for('Category-Product', function ($trail, $category) {
    $trail->parent('Home');
    $trail->push($category->title, route('shop.getcategory',$category->alias));
});
// Home > Back > Product
Breadcrumbs::for('Product', function ($trail, $product, $category) {
    $trail->parent('Category-Product',$category);
    $trail->push($product->title);
});

