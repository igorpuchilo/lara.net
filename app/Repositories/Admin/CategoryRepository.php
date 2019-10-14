<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Category;
use Menu;
use DB;

class CategoryRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function getModelClass()
    {
        return Category::class;
    }
    public function buildMenu($arr){
        $mBuilder = Menu::make('Nav', function ($m) use ($arr){
           foreach ($arr as $item){
               if ($item->parent_id == 0){
                   $m->add($item->title,$item->id)->id($item->id);
               }else{
                   if($m->find($item->parent_id)){
                       $m->find($item->parent_id)
                           ->add($item->title, $item->id)
                           ->id($item->id);
                   }
               }
           }
        });
        return $mBuilder;
    }

    public function checkChildren($id){
        $child = $this->startConditions()
            ->where('parent_id', $id)
            ->count();
        return $child;
    }

    public function checkParentsProducts($id){
        $parent = DB::table('products')
            ->where('category_id', $id)
            ->count();
        return $parent;
    }
    public function delCategory($id){
        $del = $this->startConditions()
            ->find($id)
            ->forceDelete();
        return $del;
    }
    public function getImplodeCategories(){
        $col = implode(',', ['id','parent_id','title','CONCAT (id, ". ", title) AS combo_title',]);
        $res = $this->startConditions()
            ->selectRaw($col)
            ->toBase()
            ->get();
        return $res;
    }

    public function checkUniqueName($title,$id){
        $name = $this->startConditions()
            ->where('title','=',$title)
            ->where('parent_id','=',$id)
            ->exists();
        return $name;
    }
}