<?php

namespace App\Http\Controllers\Shop\Admin;
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
    }
    //result page
    public function index(Request $request){
        MetaTag::setTags(['title' => 'Search Results']);
        $query = !empty(trim($request->search)) ? trim($request->search) : null;
        $paginate = 15;
        $products = $this->mainRepository->getSearchResult($query,$paginate);
        $curr = $this->mainRepository->getBaseCurr();

        return view('shop.admin.search.result',compact('query','products','curr'));
    }
    //autocomplete
    public function search(Request $request)
    {
        $search = $request->get('term');
        $res = $this->mainRepository->getAutocompleteByTerms($search);
        return response()->json($res);
    }
}
