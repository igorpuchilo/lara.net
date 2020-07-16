<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use SoftDeletes,Sortable;
    public $sortable = [
        'id',
        'status',
        'title',
        'price',
        'created_at'
    ];
    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'alias',
        'content',
        'price',
        'old_price',
        'status',
        'keywords',
        'description',
        'img',
        'hit',
        'parent_id',
    ];
    public function categorySortable($query, $direction)
    {
        return $query->orderBy('category', $direction);
    }
}
