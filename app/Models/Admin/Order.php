<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use SoftDeletes,Sortable;
    public $sortable = [
        'id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'currency',
        'sum'
    ];
    protected $fillable = [
        'id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'currency',
        'note',
        'sum'
    ];
    public function nameSortable($query, $direction)
    {
        return $query->orderBy('name', $direction);
    }
}
