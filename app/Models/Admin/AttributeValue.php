<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AttributeValue extends Model
{
    use Sortable;

    public $timestamps = false;
    public $sortable =[
        'id',
        'value',
        'attr_group_id',
    ];
    protected $fillable = [
        'value',
        'attr_group_id',
    ];
    public function groupsSortable($query, $direction)
    {
        return $query->orderBy('category_title', $direction);
    }
}
