<?php

namespace App\Http\Controllers\Shop;

use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\CurrencyRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Main\MainRepository;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->mainRepository = app(MainRepository::class);
        $this->productRepository = app(ProductRepository::class);
        $this->currencyRepository = app(CurrencyRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }
    //result page
    public function index(Request $request){
        MetaTag::setTags(['title' => 'Search Results']);
        $query = !empty(trim($request->search)) ? trim($request->search) : null;
        $paginate=12;
        $products = $this->productRepository->getSearchResult($query,$paginate);
        $curr = $this->currencyRepository->getBaseCurrency();
        $arrmenu = Category::all();
        $menu = $this->categoryRepository->buildMenu($arrmenu);
        if (Auth::check()) {
            $id =\Auth::user()->id;
            $countOrders = $this->mainRepository->getUserCountOrders($id);
            return view('shop.search.result',['menu' => $menu], compact('countOrders','query',
                'products','curr'));
        }
        return view('shop.search.result',compact('query','products','curr'));
    }
    //autocomplete
    public function search(Request $request)
    {
        $search = $request->get('term');
        $res = $this->productRepository->getAutocompleteByTerms($search);
        return response()->json($res);
    }
}
