<?php

namespace App\Http\Controllers\Shop\Admin;
use DB;
use Illuminate\Http\Request;
use MetaTag;

class SearchController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){
        MetaTag::setTags(['title' => 'Search Results']);
        $query = !empty(trim($request->search)) ? trim($request->search) : null;
        $products = DB::table('products')
            ->where('title','LIKE','%' . $query . '%')
            ->get()
            ->all();
        $currency = DB::table('currencies')
            ->where('base', '=', '1')
            ->first();

        return view('shop.admin.search.result',compact('query','products','currency'));
    }

    public function search(Request $request)
    {
        $search = $request->get('term');
        $res = DB::table('products')
            ->select('title')
            ->where('title', 'LIKE','%' . $search . '%')
            ->pluck('title');
        return response()->json($res);
    }
}
