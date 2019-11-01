<?php

namespace App\Http\Controllers\Shop\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
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
            abort(404);
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
        if ($request->isMethod('POST')) {
            $user->email = $request['email'];
            $request['password'] == null ?: $user->password = bcrypt($request['password']);
            $res = $user->save();
            if (!$res) {
                return back()->withErrors(['msg' => 'Error on update!'])->withInput();
            } else {
                return redirect()->route('shop.user.profile.edit', $user->id)->with(['success' => 'Saved']);
            }
        }else{
            $item = $this->userRepository->getId(\Auth::user()->id);
            if (empty($item)) abort(404);
            return view('shop.user.edit', compact('item'));
        }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function showChangePasswordForm(){
        return view('auth.passwords.email');
    }
}
