<?php

// Home
Breadcrumbs::for('Home', function ($trail) {
    $trail->push('Home', url('/home'));
});
//Back
Breadcrumbs::for('Back', function ($trail) {
    $trail->parent('Home');
    $trail->push('Back', url()->previous());
});
// Home > Cart
Breadcrumbs::for('Cart', function ($trail) {
    $trail->parent('Home');
    $trail->push('Cart', route('cart'));
});

// Home > Category
Breadcrumbs::for('Category', function ($trail, $category) {
    $trail->parent('Home');
    $trail->push($category->title, route('shop.getcategory', $category->id));
});

// Home > Back > Product
Breadcrumbs::for('Product', function ($trail, $product) {
    $trail->parent('Back');
    $trail->push($product->title, route('shop.getproduct', $product->id));
});

