<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Shop\BaseController;
use App\Http\Requests\ShopCategoryUpdateRequest;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class CategoryController extends AdminBaseController
{

    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        MetaTag::setTags(['title'=>'Category List']);

        $arrmenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrmenu);
        return view('shop.admin.category.index', ['menu' => $menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        MetaTag::setTags(['title'=>'Create New Category']);

        $item = new Category();
        $categoryList = $this->categoryRepository->getImplodeCategories();
        return view('shop.admin.category.create',['categories'=>Category::with('children')
            ->where('parent_id','=','0')->get(),'delimiter' => '-','item'=>$item]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function mdel(){
        $id = $this->categoryRepository->getRequestID();
        if (!$id){
            return back()->withErrors(['msg'=>'ID id missing!']);
        }
        $child = $this->categoryRepository->checkChildren($id);
        if ($child){
            return back()->withErrors(['msg'=>'Cannot delete. Item have child dependence']);
        }

        $parents = $this->categoryRepository->checkParentsProducts($id);
        if ($parents){
            return back()->withErrors(['msg'=>'Cannot delete. Item have products!']);
        }
        $del = $this->categoryRepository->delCategory($id);
        if ($del){
            return redirect()->route('shop.admin.categories.index')
                ->with(['success' => 'Category has been deleted!']);
        }else{
            return back()->withErrors(['msg'=>'Error on delete!']);
        }
    }

    public function store(ShopCategoryUpdateRequest $request)
    {
        $title = $this->categoryRepository->checkUniqueName($request->title, $request->parent_id);
        if ($title){
            return back()
                ->withErrors(['msg'=>'Already Exist!'])->withInput();
        }
        $data = $request->input();
        $item = new Category();
        $item->fill($data)->save();
        if ($item){
            return redirect()
                ->route('shop.admin.categories.create', [$item->id])
                ->with(['success' => 'Saved']);
        }else{
            return back()->withErrors(['msg'=>'Error on Save!'])->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, CategoryRepository $categoryRepository)
    {
        MetaTag::setTags(['title'=>'Edit Category']);
        $item = $this->categoryRepository->getId($id);
        if (empty($item)){
            abort(404);
        }
        return view('shop.admin.category.edit',['categories'=>Category::with('children')
            ->where('parent_id','=','0')->get(),'delimiter' => '-','item'=>$item,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopCategoryUpdateRequest $request, $id)
    {
        $item = $this->categoryRepository->getId($id);
        if (empty($item)){
            return back()
                ->withErrors(['msg'=>'Category not found'])
                ->withInput();
        }
        $data = $request->all();
        $res = $item->update($data);
        if ($res){
            return redirect()
                ->route('shop.admin.categories.edit', $item->id)
                ->with(['success' => 'Saved']);
        }else{
            return back()
                ->withErrors(['msg'=>'Error on Save!'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
