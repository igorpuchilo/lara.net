<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductOrders extends Model
{
    protected $table = 'order_products';
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'title',
        'price',
    ];
}