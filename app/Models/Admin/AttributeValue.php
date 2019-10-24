<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'value',
        'attr_group_id',
    ];
}
