<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Order;
use DB;

class OrderRepository extends CoreRepository
{
    private $currencyRepository;
    private $productOrdersRepository;//!!!!!
    public function __construct()
    {
        parent::__construct();
        $this->currencyRepository = app(CurrencyRepository::class);
        //$this->productOrdersRepository = app(ProductOrdersRepository::class); CRITICAL ERROR
    }

    protected function getModelClass()
    {
        return Order::class;
    }
    public function updateSummary($order_id,$sum){
        $old_sum = DB::table('orders')->where('id',$order_id)->select('orders.sum')->first();
        $new_sum = $sum + $old_sum->sum;
        $order = $this->startConditions()->find($order_id);
        $order->sum = $new_sum;
        return $order->save();
    }
    public  function getOrderIdByUserID($id){
        $order_id = $this->startConditions()->where([['orders.user_id','=',$id],['status','=','3'],])->first();
        if($order_id){
            return $order_id->id;
        }else{
            $new_order = new Order();
            $new_order->user_id = $id;
            $new_order->status = '3';
            $new_order->currency = $this->currencyRepository->getBaseCurrency()->code;
            $new_order->Note = '';
            $new_order->save();
            return $new_order->id;
        }

    }
    public function deleteProductFromOrder($id){
        $order = DB::table('order_products')
            ->where('id', $id)
            ->select('order_products.order_id',DB::raw('(order_products.price*order_products.qty) AS sum'))
            ->first();
        $sum = $this->startConditions()->where('id','=',$order->order_id)->select('sum')->first();
        $sum = $sum->sum - $order->sum;
        $this->startConditions()
            ->where('id', $order->order_id)
            ->update(['sum' => $sum]);
        return DB::table('order_products')
            ->where('id',$id)
            ->delete();
    }
    public function setOrderStatus($status,$id){
        $order =$this->startConditions()::withTrashed()
            ->find($id);
        $order->status = $status;
        return $order->save();

    }
    public function getAllOrders($paginate)
    {
        return $this->startConditions()::withTrashed()
            ->join('users','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->select('orders.id','orders.user_id','orders.status','orders.created_at',
                'orders.updated_at','orders.currency','users.name',
                DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->groupBy('orders.id')
            ->sortable()
            ->toBase()
            ->paginate($paginate);
    }
    public function getUserOrder($id){
        return $this->startConditions()::withTrashed()
            ->join('users','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->select('orders.*', 'users.name')
            ->where([['orders.id','=',$id],['status','=','3'],])
            ->groupBy('orders.id')
            ->first();
    }
    public function getOneOrder($id){
        $order = $this->startConditions()::withTrashed()
            ->join('users','orders.user_id','=','users.id')
            ->join('order_products','order_products.order_id','=','orders.id')
            ->select('orders.*', 'users.name',
                DB::raw('ROUND(SUM(order_products.price),2) AS sum'))
            ->where('orders.id','=',$id)
            ->groupBy('orders.id')
            ->orderBy('orders.status')
            ->orderBy('orders.id')
            ->first();
        return $order;

    }

    public function saveOrderComment($id){
        $item = $this->getId($id);
        if (!$item) abort(404);
        $item->note = !empty($_POST['comment']) ? $_POST['comment'] : null;
        $item->status = 0;
        return $item->save();
    }

    public  function getAllOrderProductsId($id){
        return DB::table('order_products')
            ->join('products','order_products.product_id','=','products.id')
            ->where('order_id','=',$id)
            ->select('order_products.*', 'products.alias as alias', 'products.title as prod_title')
            ->get();
    }
    public function getUserCountOrders($id){
        return $order_id =$this->startConditions()
            ->where([['user_id','=',$id],['status','=','3'],])
            ->select('id')
            ->first();
    }

    public function changeStatusOrder($id){
        $item = $this->getId($id);
        if (!$item) abort(404);
        $item->status = !empty($_GET['status']) ? '1' : '0';
        return $item->save();
    }
    public function changeStatusOnDelete($id){
        $item = $this->getId($id);
        if (!$item){
            abort(404);
        }
        $item->status = '2';
        return $item->save();
    }
    public function restore($id){
        return $this->startConditions()::withTrashed()
            ->find($id)
            ->restore();
    }

}