<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreSettings extends Model
{
    protected $table = 'store_settings';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'param_name',
        'param_description',
        'value'
    ];
}
