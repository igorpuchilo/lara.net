<?php


namespace App\Repositories\Admin;

use App\Models\Admin\AttributeGroup;
use App\Repositories\CoreRepository;
use DB;

class FilterGroupRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return AttributeGroup::class;
    }
    public function getAllGroupsFilter(){
        return $this->startConditions()
            ->join('categories', 'categories.id', '=',
                'attribute_groups.category_id')
            ->select('attribute_groups.*','categories.title as category_title')
            ->get();
    }
    public function getAllGroupsFilterSort($paginate){
        return $this->startConditions()
            ->join('categories', 'categories.id', '=',
                'attribute_groups.category_id')
            ->select('attribute_groups.*','categories.title as category_title')
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }
    public function getFiltersByAttrs($attrs){
        return $this->startConditions()
            ->join('attribute_values','attribute_values.attr_group_id','=','attribute_groups.id')
            ->select('attribute_values.value','attribute_groups.title')
            ->whereIn('attribute_values.id',$attrs)
            ->get();
    }
    public function getInfoGroup($id){
        return $this->startConditions()->find($id);
    }
    public function deleteGroupFilter($id){
        return $this->startConditions()->where('id','=',$id)->forceDelete();
    }
    public function getCountGroupFilter(){
        return DB::table('attribute_values')->count();
    }
    public function getGroupIdByParentId($id){
        return $this->startConditions()
            ->select('id')
            ->where('category_id',$id)
            ->toArray();
    }
    public function getAllFilterGroupsByParentId($id){
        return $this->startConditions()->where('category_id','=',$id)->orderBy('title')->get();
    }
}