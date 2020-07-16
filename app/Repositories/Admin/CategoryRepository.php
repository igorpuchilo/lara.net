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
        return Menu::make('Nav', function ($m) use ($arr){
           foreach ($arr as $item){
               if ($item->parent_id == 0){
                   $m->add($item->title, $item->id)->id($item->id)
                       ->data('alias',$item->alias);

               }else{
                   if($m->find($item->parent_id)){
                       $m->find($item->parent_id)
                           ->add($item->title, $item->id)
                           ->id($item->id)
                           ->data('alias',$item->alias);
                   }
               }
           }
        });
    }

    public function checkChildren($id){
        return $this->startConditions()
            ->where('parent_id', $id)
            ->count();
    }

    public function checkParentsProducts($id){
        return DB::table('products')
            ->where('category_id', $id)
            ->count();
    }
    public function delCategory($id){
        return $this->startConditions()
            ->find($id)
            ->forceDelete();
    }
    public function getImplodeCategories(){
        $col = implode(',', ['id','parent_id','title','CONCAT (id, ". ", title) AS combo_title',]);
        return $this->startConditions()
            ->selectRaw($col)
            ->toBase()
            ->get();
    }
    public function getSubCategories($id){
        return $this->startConditions()
            ->where('parent_id', '=', $id)
            ->get();
    }

    public function checkUniqueName($title,$id){
        return $this->startConditions()
            ->where('title','=',$title)
            ->where('parent_id','=',$id)
            ->exists();
    }
    public function getParentCategories(){
        return $this->startConditions()
            ->where('parent_id','=','0')
            ->get();
    }
}