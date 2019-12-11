<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AttributeProducts extends Model
{
    protected $table = 'attribute_products';
    public $timestamps = false;
    protected $fillable = [
        'attr_id',
        'product_id',
    ];
}
