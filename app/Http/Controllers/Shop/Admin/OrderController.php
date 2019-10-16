<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Models\Admin\Order;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminOrderSaveRequest;
use App\Http\Controllers\Controller;
use DB;
class OrderController extends AdminBaseController
{
    private $orderRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginatepages = 5;
        $countOrders = MainRepository::getCountOrders();
        $orders = $this->orderRepository->getAllOrders($paginatepages);
        \MetaTag::setTags(['title'=>'Orders list']);
        return view('shop.admin.order.index',compact('countOrders','orders'));
    }


    public function forceDelete($id){
        if (empty($id)){
            return back()->withErrors(['msg'=>'This order not found!']);
        }
        $res = DB::table('orders')
            ->delete($id);
        if ($res){
            return redirect()->route('shop.admin.orders.index')
                ->with(['success' => "Order #$id has been deleted from database"]);
        }else {
            return back()->withErrors(['msg'=>'Error on delete from database!']);
        }
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
    public function save(AdminOrderSaveRequest $request,$id){
        $result = $this->orderRepository->saveOrderComment($id);
        if ($result){
            return redirect()
                ->route('shop.admin.orders.edit', $id)
                ->with(['success' => 'Saved!']);
        } else {
            return back()
                ->withErrors(['msg'=>'Save Failed!']);
        }
    }
    public function change($id){
        $res = $this->orderRepository->changeStatusOrder($id);

        if ($res) {
            return redirect()
                ->route('shop.admin.orders.edit', $id)
                ->with(['success'=> 'Saved']);
        } else {
            return back()
                ->withErrors(['msg' => 'Error on save!']);
        }

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
    public function edit($id)
    {
        $item = $this->orderRepository->getId($id);
        if (empty($item)){
            abort(404);
        }

        $order = $this->orderRepository->getOneOrder($item->id);
        if (!$order){
            abort(404);
        }

        $order_prod = $this->orderRepository->getAllOrderProductsId($item->id);

        \MetaTag::setTags(['title'=>"Order # {$item->id}"]);

        return view('shop.admin.order.edit',compact('item', 'order','order_prod'));
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
        $st = $this->orderRepository->changeStatusOnDelete($id);
        if ($st){
            $result = Order::destroy($id);
            if ($result){
                return redirect()->route('shop.admin.orders.index')
                    ->with(['success' => "Order #[$id] deleted"]);
            }else {
                return back()->withErrors(['msg'=>'Error on delete']);
            }
        }
        return back()->withErrors(['msg'=>'Status not change']);



    }
}
