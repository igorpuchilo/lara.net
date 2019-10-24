<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];
}
