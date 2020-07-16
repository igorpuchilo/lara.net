<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Models\Admin\Order;
use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductOrdersRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminOrderSaveRequest;
use DB;
class OrderController extends AdminBaseController
{
    private $orderRepository;
    private $productOrdersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
        $this->productOrdersRepository = app(ProductOrdersRepository::class);
    }

    /**
     * Orders List index
     */
    public function index()
    {
        $paginatepages = 15;
        $countOrders = MainRepository::getCountOrders();
        $orders = $this->orderRepository->getAllOrders($paginatepages);
        \MetaTag::setTags(['title'=>'Orders list']);
        return view('shop.admin.order.index',compact('countOrders','orders'));
    }

    // delete order from DB action
    public function forceDelete($id){
        if (empty($id)){
            return back()->withErrors(['msg'=>'This order not found!']);
        }
        $res = DB::table('orders')
            ->delete($id);
        DB::table('order_products')->where('order_id',$id)->delete();
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
    //edit order (Add comment)
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
    //Edit order status
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

    //order details action -> show edit view
    public function edit($id)
    {
        $order = $this->orderRepository->getOneOrder($id);
        if (!$order){
            abort(404);
        }

        $order_prod = $this->orderRepository->getAllOrderProductsId($id);

        \MetaTag::setTags(['title'=>"Order # {$order->id}"]);

        return view('shop.admin.order.edit',compact('order','order_prod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        if($this->orderRepository->setOrderStatus('3',$id)){
            return redirect()->route('shop.admin.orders.index')
                ->with(['success' => "Order #[$id] Was Restored To User Cart!"]);
        }else{
            return back()
                ->withErrors(['msg' => 'Error on change status!']);
        }
    }

    //disable order action
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
    public function restore($id){
        $st = $this->orderRepository->restore($id);
        if ($st){
            $result = $this->orderRepository->changeStatusOrder($id);
            if ($result){
                return redirect()->route('shop.admin.orders.index')
                    ->with(['success' => "Order #[$id] was restored"]);
            }else {
                return back()->withErrors(['msg'=>'Error on restore']);
            }
        }
        return back()->withErrors(['msg'=>'Status not change']);
    }
    public function deleteProduct($id){
        if ($this->orderRepository->deleteProductFromOrder($id)) {
            return back()->withInput();
        } else {
            return back()->withErrors(['msg' => 'Error on delete!'])->withInput();
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
