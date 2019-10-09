<?php

namespace App\Http\Controllers\Shop\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Shop\BaseController as MainBaseController;

abstract class AdminBaseController extends MainBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');

//        MetaTag::setTags([
//
//        ]);
    }
}
