<?php

namespace App\Http\Controllers\Shop\Admin;
use App\Repositories\Admin\CurrencyRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Main\MainRepository;
use DB;
use Illuminate\Http\Request;
use MetaTag;

class SearchController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->mainRepository = app(MainRepository::class);
        $this->productRepository = app(ProductRepository::class);
        $this->currencyRepository = app(CurrencyRepository::class);
    }
    //result page
    public function index(Request $request){
        MetaTag::setTags(['title' => 'Search Results']);
        $query = !empty(trim($request->search)) ? trim($request->search) : null;
        $paginate = 15;
        $products = $this->productRepository->getSearchResult($query,$paginate);
        $curr = $this->currencyRepository->getBaseCurrency();

        return view('shop.admin.search.result',compact('query','products','curr'));
    }
    //autocomplete
    public function search(Request $request)
    {
        $search = $request->get('term');
        $res = $this->productRepository->getAutocompleteByTerms($search);
        return response()->json($res);
    }
}
