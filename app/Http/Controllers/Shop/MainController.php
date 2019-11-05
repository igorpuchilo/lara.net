<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Main\MainRepository;
use Auth;
use MetaTag;
use App\Models\Admin\Category;

class MainController extends Controller
{


    public function __construct()
    {
        $this->mainRepository = app(MainRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => "My Store"]);
        $paginatepages = 15;
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        $last_products = $this->mainRepository->getLastProducts($paginatepages);
        if (Auth::check()) {
            $id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.home',['menu' => $menu], compact('countOrders','last_products'));
        }
        return view('shop.home',['menu' => $menu], compact('last_products'));
    }
    public function getProduct($id){
        $product = $this->mainRepository->getProductById($id);
        $curr = $this->mainRepository->getBaseCurr();
        MetaTag::setTags(['title' => $product->title]);
        $filter = $this->mainRepository->getAttributesProduct($id);
        $groupfilter = $this->mainRepository->getAllFilterGroups();
        $related = $this->mainRepository->getRelatedProducts($id);
        $images = $this->mainRepository->getGallery($id);
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        if (Auth::check()) {
            $id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.product',['menu' => $menu], compact('countOrders','product', 'filter', 'related', 'images', 'id', 'curr', 'groupfilter') );
        }
        return view('shop.product',['menu' => $menu], compact('product', 'filter', 'related', 'images', 'id', 'curr', 'groupfilter'));
    }

}
