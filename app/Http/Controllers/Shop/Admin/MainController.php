<?php

namespace App\Http\Controllers\Shop\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class MainController extends AdminBaseController
{
    public function index()
    {
        MetaTag::setTags(['title'=>'Admin Panel']);

        return view('shop.admin.main.index');
    }
}
