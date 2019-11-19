<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AttributeGroup extends Model
{
    use Sortable;

    public $sortable = [
        'title',
    ];
    public $timestamps = false;

    protected $fillable = [
        'title',
        'category_id',
    ];
    public function categoriesSortable($query, $direction)
    {
        return $query->orderBy('category_title', $direction);
    }

}
