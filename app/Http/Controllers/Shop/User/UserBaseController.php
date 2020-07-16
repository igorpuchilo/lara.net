<?php


namespace App\Http\Controllers\Shop\User;


use App\Http\Controllers\Controller;

class UserBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
}