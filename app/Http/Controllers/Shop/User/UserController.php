<?php

namespace App\Http\Controllers\Shop\User;

use App\Models\User;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductOrdersRepository;
use App\Repositories\User\UserRepository;
use App\Models\Admin\Category;
use Auth;
use Illuminate\Http\Request;
use MetaTag;

class UserController extends UserBaseController
{
    private $productOrdersRepository;
    private $orderRepository;
    public function __construct()
    {
        parent::__construct();
        $this->productOrdersRepository = app(ProductOrdersRepository::class);
        $this->orderRepository = app(OrderRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    public function index()
    {
        MetaTag::setTags(['title' => "My Cart"]);


        $id = \Auth::user()->id;

        $countOrders = $this->userRepository->getCountOrders($id);

        $arrmenu = Category::all();
        $menu = $this->userRepository->buildMenu($arrmenu);

        $order = $this->userRepository->getUserOrder($id);
        if (!$order) {
            return view('shop.user.index', ['menu' => $menu], compact('countOrders'));
        }
        $order_prod = $this->userRepository->getAllUserOrderProducts($order->id);

        return view('shop.user.index', ['menu' => $menu], compact('order', 'order_prod', 'countOrders'));
    }
    public function orderHistory()
    {
        MetaTag::setTags(['title' => "My Orders History"]);
        $order_prods = array();

        $id = \Auth::user()->id;

        $arrmenu = Category::all();
        $menu = $this->userRepository->buildMenu($arrmenu);

        $countOrders = $this->userRepository->getCountOrders($id);

        $orders = $this->userRepository->getUserOrderHistory($id);
        if (!$orders) {
            return view('shop.user.order-history', ['menu' => $menu], compact('countOrders'));
        }
        foreach ($orders as $order){
            array_push($order_prods, $this->userRepository->getAllUserOrderProducts($order->id));
        }
        return view('shop.user.order-history', ['menu' => $menu], compact('orders', 'order_prods', 'countOrders'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->userRepository->saveOrder($request->order_id)) {
            return redirect('/cart');
        } else {
            return back()->withErrors(['msg' => 'Error on save!'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            if ($this->userRepository->deleteProductFromOrder($id)) {
                return back()->withInput();
            } else {
                return back()->withErrors(['msg' => 'Error on delete!'])->withInput();
            }
        }
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function addOrder(Request $request)
    {
        $cnt = $request->productQuantity ? $request->productQuantity : $request->quant[$request->product_id];
        if ($this->userRepository->AddOrder(Auth::user()->id, $cnt, $request->price, $request->product_id,
            $request->product_title)) {
            return back()->withInput()->with(['success' => 'Added To Cart!']);
        } else {
            return back()->withInput()->withErrors(['msg' => 'Failed!']);
        }


    }
    public function ajaxProdQtyChange(Request $request){
        if($this->productOrdersRepository->changeProductQty($request->product_id,$request->qty)){
            $prods = $this->productOrdersRepository->getProductsByOrderId($request->order_id);
            if($prods){
                return $this->orderRepository->updateSum($request->order_id,$prods);
            }else return false;
        }else return false;
    }
}
