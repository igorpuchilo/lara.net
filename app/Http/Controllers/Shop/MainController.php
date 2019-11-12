<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Main\MainRepository;
use Auth;
use MetaTag;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
class MainController extends Controller
{


    public function __construct()
    {
        $this->mainRepository = app(MainRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => "My Store"]);
        $paginatepages = 12;
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        $products = $this->mainRepository->getLastProducts($paginatepages);
        $curr = $this->mainRepository->getBaseCurr();
        if (Auth::check()) {
            $id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.home',['menu' => $menu], compact('countOrders','products', 'curr'));
        }
        return view('shop.home',['menu' => $menu], compact('products', 'curr'));
    }
    public function getProduct($id){
        $currentProduct = $this->mainRepository->getProductById($id);
        if ($currentProduct->status == 0){
            abort(404);
        }
        $curr = $this->mainRepository->getBaseCurr();
        MetaTag::setTags(['title' => $currentProduct->title]);
        $filters = $this->mainRepository->getAttributesProduct($id);
        $attributes = $this->mainRepository->getAllAttributes();
        $groupfilter = $this->mainRepository->getAllFilterGroups();
        $limit = 4;
        $related = $this->mainRepository->getRelatedProducts($id,$limit);
        $images = $this->mainRepository->getGallery($id);
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        if (Auth::check()) {
            $id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.product',['menu' => $menu], compact('countOrders','currentProduct',
                'filters', 'related', 'images', 'id', 'curr', 'groupfilter','attributes') );
        }
        return view('shop.product',['menu' => $menu], compact('currentProduct', 'filters',
            'related', 'images', 'id', 'curr', 'groupfilter','attributes'));
    }
    public function getCategory($id){
        $curr = $this->mainRepository->getBaseCurr();
        $paginate = 25;
        MetaTag::setTags(['title' => 'Category *****']);
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        $category = $this->mainRepository->getCategoryById($id);
        $attributes = $this->mainRepository->getAllAttributes();
        $groupfilter = $this->mainRepository->getAllFilterGroups();
        if (Auth::check()) {
            $user_id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($user_id);
            $products = $this->mainRepository->getProductsByCategoryId($id,$paginate);
            return view('shop.category',['menu' => $menu], compact('countOrders', '$user_id', 'curr',
                'products','category','attributes','groupfilter'));
        }
        $products = $this->mainRepository->getProductsByCategoryId($id);
        return view('shop.category',['menu' => $menu], compact( '$user_id', 'curr','products',
            'category','attributes','groupfilter'));
    }
    public function getProductsByFilters(Request $request){

    }
}
