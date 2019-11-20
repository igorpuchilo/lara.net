<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Order;
use DB;

class OrderRepository extends CoreRepository
{
    private $currencyRepository;
    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepository::class);
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Order::class;
    }
    public function updateSummary($order_id,$sum){
        $order = $this->startConditions()->find($order_id);
        $order->sum = $order->sum + $sum;
        return $order->save();
    }
    public  function getOrderIdByUserID($id){
        $order_id = $this->startConditions()->where('orders.user_id','=',$id)->first();
        if($order_id){
            return $order_id->id;
        }else{
            $new_order = new Order();
            $new_order->user_id = $id;
            $new_order->status = '0';
            $new_order->currency = $this->currencyRepository->getBaseCurrency()->code;
            $new_order->Note = '';
            $new_order->save();
            return $new_order->id;
        }

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
        return $item->update();
    }

    public  function getAllOrderProductsId($id){
        return DB::table('order_products')
            ->where('order_id','=',$id)
            ->get();
    }

    public function changeStatusOrder($id){
        $item = $this->getId($id);
        if (!$item) abort(404);
        $item->status = !empty($_GET['status']) ? '1' : '0';
        return $item->update();
    }
    public function changeStatusOnDelete($id){
        $item = $this->getId($id);
        if (!$item){
            abort(404);
        }
        $item->status = '2';
        return $item->update();
    }
    public function restore($id){
        return $this->startConditions()::withTrashed()
            ->find($id)
            ->restore();
    }

}