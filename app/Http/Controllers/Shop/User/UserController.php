<?php

namespace App\Http\Controllers\Shop\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Auth;
use Illuminate\Http\Request;
use MetaTag;

class UserController extends UserBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    public function index()
    {
        MetaTag::setTags(['title' => "My Cart"]);


        $id =\Auth::user()->id;

        $countOrders = $this->userRepository->getCountOrders($id);

        $order = $this->userRepository->getUserOrder($id);
        if (!$order){
            return view('shop.user.index', compact(  'countOrders'));
        }
        $order_prod = $this->userRepository->getAllUserOrderProducts($id);

        return view('shop.user.index', compact( 'order','order_prod', 'countOrders'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            if ($this->userRepository->saveOrder($id)){
                return back()->withInput();
            }else
            {
                return back()->withErrors(['msg'=>'Error on save!'])->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            if ($this->userRepository->deleteProductFromOrder($id)){
                return back()->withInput();
            }else
            {
                return back()->withErrors(['msg'=>'Error on delete!'])->withInput();
            }
        }
    }
    public function showChangePasswordForm(){
        return view('auth.passwords.email');
    }

    public function addOrder(Request $request, $id){
        if (Auth::check()){
            if($this->userRepository->AddOrder(Auth::user()->id,$request->productQuantity,$request->price,$id,
                $request->product_title)){
                return back()->withInput()->with(['success'=>'Added To Cart!']);
            }else{
                return back()->withInput()->withErrors(['msg'=>'Failed!']);
            }

        }
    }
}
