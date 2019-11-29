<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\SettingsRepository;
use App\Repositories\Main\MainRepository;
use Auth;
use View;
use MetaTag;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $mainRepository;

    public function __construct()
    {
        $this->mainRepository = app(MainRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => \App\Shop\Core\ShopApp::get_Instance()->getProperty('store_name_tab')]);
        $paginatepages = 12;
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        $products = $this->mainRepository->getLastProducts($paginatepages);
        $curr = $this->mainRepository->getBaseCurr();
        if (Auth::check()) {
            $id = \Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.home', ['menu' => $menu], compact('countOrders', 'products', 'curr'));
        }
        return view('shop.home', ['menu' => $menu], compact('products', 'curr'));
    }

    public function getProduct($alias)
    {
        $product = $this->mainRepository->getProductByAlias($alias);
        //$product = $this->mainRepository->getProductById(5);
        if (empty($product)||$product->status == 0) {
            abort(404);
        }
        $category = $this->mainRepository->getCategoryById($product->category_id);
        $curr = $this->mainRepository->getBaseCurr();
        MetaTag::setTags(['title' => $product->title]);
        $attrs = $this->mainRepository->getAttributesProduct($product->id);
        $filters = $this->mainRepository->getFiltersByAttrs($attrs);
        $limit = 4;
        $related = $this->mainRepository->getRelatedProducts($product->id, $limit);
        $images = $this->mainRepository->getGallery($product->id);
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        if (Auth::check()) {
            $id = \Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.product', ['menu' => $menu], compact('countOrders', 'product',
                'filters', 'related', 'images', 'id', 'curr', 'category'));
        }
        return view('shop.product', ['menu' => $menu], compact('product', 'filters',
            'related', 'images', 'id', 'curr', 'category'));
    }

    public function getCategory(Request $request, $alias)
    {
        $curr = $this->mainRepository->getBaseCurr();
        $paginate = 12;
        $groups = array();
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
        $attrs = array();
        $category = $this->mainRepository->getCategoryByAlias($alias);
        if (empty($category)) {
            abort(404);
        }
        MetaTag::setTags(['title' => "$category->title"]);
        $groupsfilter = $this->mainRepository->getAllFilterGroupsByParentId($category->parent_id);
        if (!empty($groupsfilter)) {
            foreach ($groupsfilter as $group) {
                array_push($groups, $group->id);
            }
        }
        $attributes = $this->mainRepository->getAllAttributesByGroupsId($groups);
        if(isset($request->sortBy)){
            $sortBy = $request->sortBy;
        }
        if (isset($request->attrs)) {
            $attrs = $request->attrs;
            $products = $this->mainRepository->getProductsByAttrsAndCat($attrs, $paginate, $category->id);
        } else {
            $products = $this->mainRepository->getProductsByCategoryId($category->id, $paginate);
        }
        if (Auth::check()) {
            $user_id = \Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($user_id);
            return view('shop.category', ['menu' => $menu], compact('countOrders', '$user_id', 'curr',
                'products', 'category', 'attributes', 'groupsfilter','attrs','sortBy'));
        }
        return view('shop.category', ['menu' => $menu], compact('$user_id', 'curr', 'products',
            'category', 'attributes', 'groupsfilter','attrs','sortBy'));
    }

}
