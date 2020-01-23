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
    private $mainRepository;
    private $orderRepository;
    private $userRepository;
    private $categoryRepository;
    private $productRepository;
    private $currencyRepository;
    private $filterAttrsRepository;
    private $filterGroupRepository;
    private $productOrdersRepository;


    public function __construct()
    {
        $this->mainRepository = app(MainRepository::class);
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
        $this->categoryRepository = app(\App\Repositories\Admin\CategoryRepository::class);
        $this->productRepository = app(\App\Repositories\Admin\ProductRepository::class);
        $this->currencyRepository = app(\App\Repositories\Admin\CurrencyRepository::class);
        $this->filterAttrsRepository = app(\App\Repositories\Admin\FilterAttrsRepository::class);
        $this->filterGroupRepository = app(\App\Repositories\Admin\FilterGroupRepository::class);
        $this->productOrdersRepository = app(\App\Repositories\Admin\ProductOrdersRepository::class);
    }


    public function index()
    {
        MetaTag::setTags(['title' => \App\Shop\Core\ShopApp::get_Instance()->getProperty('store_name_tab')]);
        $paginatepages = 12;
        $arrmenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrmenu);
        $products = $this->productRepository->getLastAvailableProducts($paginatepages);
        $curr = $this->currencyRepository->getBaseCurrency();
        if (Auth::check()) {
            $id = \Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.home', ['menu' => $menu], compact('countOrders', 'products', 'curr'));
        }
        return view('shop.home', ['menu' => $menu], compact('products', 'curr'));
    }

    public function getProduct($alias)
    {
        $product = $this->productRepository->getProductByAlias($alias);
        if (empty($product)||$product->status == 0) {
            abort(404);
        }
        $category = $this->categoryRepository->getId($product->category_id);
        $curr = $this->currencyRepository->getBaseCurrency();
        MetaTag::setTags(['title' => $product->title]);
        $attrs = $this->productRepository->getFiltersProduct($product->id);
        $filters = $this->filterGroupRepository->getFiltersByAttrs($attrs);
        $limit = 4;
        $related = $this->productRepository->getRelatedProductsList($product->id,$limit);
        $images = $this->productRepository->getGallery($product->id);
        $arrmenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrmenu);
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
        $curr = $this->currencyRepository->getBaseCurrency();
        $paginate = 12;
        $groups = array();
        $arrmenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrmenu);
        $attrs = array();
        $category = $this->categoryRepository->getCategoryByAlias($alias);
        if (empty($category)) {
            abort(404);
        }
        MetaTag::setTags(['title' => "$category->title"]);
        $groupsfilter = $this->filterGroupRepository->getAllFilterGroupsByParentId($category->parent_id);
        if (!empty($groupsfilter)) {
            foreach ($groupsfilter as $group) {
                array_push($groups, $group->id);
            }
        }
        $attributes = $this->filterAttrsRepository->getAllAttributesByGroupsId($groups);
        if ($request->attrs) {
            $attrs = $request->attrs;
            $products = $this->productRepository->getProductsByAttrsAndCat($attrs, $paginate, $category->id);
        } else {
            $products = $this->productRepository->getProductsByCatId($category->id, $paginate);
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
