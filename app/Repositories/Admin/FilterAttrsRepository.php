<?php


namespace App\Repositories\Admin;

use DB;
use App\Models\Admin\AttributeValue;
use App\Repositories\CoreRepository;

class FilterAttrsRepository extends CoreRepository
{
    private $filterGroupRepository;

    public function __construct()
    {
        parent::__construct();
        $this->filterGroupRepository = app(FilterGroupRepository::class);
    }

    protected function getModelClass()
    {
        return AttributeValue::class;
    }

    public function getCountFilterAttrsById($id)
    {
        return DB::table('attribute_values')->where('attr_group_id', '=', $id)->count();
    }

    public function getAllAttrsFilter($paginate)
    {
        return $this->startConditions()
            ->join('attribute_groups', 'attribute_groups.id', '=',
                'attribute_values.attr_group_id')
            ->select('attribute_values.*', 'attribute_groups.title as category_title')
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getAllAttrsFilterByParentId($id)
    {
        return DB::table('attribute_values')
            ->join('attribute_groups', 'attribute_groups.id', '=',
                'attribute_values.attr_group_id')
            ->select('attribute_values.*', 'attribute_groups.title as category_title')
            ->where('attribute_groups.id', '=', $id)
            ->get();
    }

    public function getAllAttributesByGroupsId($groups)
    {
        return $this->startConditions()
            ->wherein('attr_group_id', $groups)
            ->get();
    }

    public function getAllAttrsValues()
    {
        return $this->startConditions()::all();
    }

    public function checkUnique($name, $attr_group_id)
    {
        return $this->startConditions()
            ->where([['value', '=', $name], ['attr_group_id', '=', $attr_group_id],])->count();
    }

    public function getInfoAttribute($id)
    {
        return $this->startConditions()->find($id);
    }

    public function deleteAttrFilter($id)
    {
        if($this->startConditions()->where('id', '=', $id)->forceDelete()){
            return DB::table('attribute_products')->where('attr_id',$id)->delete();
        }


    }
}