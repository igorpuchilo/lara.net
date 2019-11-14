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
            ->orderBy('category_id')
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
}