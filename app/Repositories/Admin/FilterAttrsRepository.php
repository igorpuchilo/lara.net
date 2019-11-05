<?php


namespace App\Repositories\Admin;

use DB;
use App\Models\Admin\AttributeValue;
use App\Repositories\CoreRepository;

class FilterAttrsRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return AttributeValue::class;
    }

    public function getCountFilterAttrsById($id)
    {
        return DB::table('attribute_values')->where('attr_group_id', '=', $id)->count();
    }

    public function getAllAttrsFilter()
    {
        return DB::table('attribute_values')
            ->join('attribute_groups', 'attribute_groups.id', '=',
                'attribute_values.attr_group_id')
            ->select('attribute_values.*', 'attribute_groups.title')
            ->paginate(10);
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
    public function getProductAttributeValues($attrs){
        $res = array();
        foreach ($attrs as $attr){
            array_push($res, $this->startConditions()->find($attr)->select('attribute_values.value'));
        }
        return $res;
    }
    public function deleteAttrFilter($id)
    {
        return $this->startConditions()->where('id', '=', $id)->forceDelete();
    }
}