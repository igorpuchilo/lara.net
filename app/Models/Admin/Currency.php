<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Currency extends Model
{
    use Sortable;
    public $timestamps = false;
    public $sortable = [
        'id',
        'title',
        'code',
        'value',
        'base'
    ];
    protected $fillable = [
      'title',
      'code',
      'symbol_left',
      'symbol_right',
      'value',
      'base',
    ];
}
