<?php

namespace App\Http\Controllers\Shop;

use App\Models\Admin\Category;
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
    }
    //result page
    public function index(Request $request){
        MetaTag::setTags(['title' => 'Search Results']);
        $query = !empty(trim($request->search)) ? trim($request->search) : null;
        $paginate=12;
        $products = $this->mainRepository->getSearchResult($query,$paginate);
        $curr = $this->mainRepository->getBaseCurr();
        $arrmenu = Category::all();
        $menu = $this->mainRepository->buildMenu($arrmenu);
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
        $res = $this->mainRepository->getAutocompleteByTerms($search);
        return response()->json($res);
    }
}
