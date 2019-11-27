<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Controller;

//Base for future controllers include admin auth
abstract class AdminBaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');
    }
}
