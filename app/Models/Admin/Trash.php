<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Trash extends Model
{
    use Sortable;
    protected $table = 'trash';
    public $timestamps = false;
    public $sortable = [
        'id',
        'file'
    ];
    protected $fillable = [
        'id',
        'file'
    ];
}
