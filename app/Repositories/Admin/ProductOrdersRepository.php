<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\ProductOrders;
use DB;

class ProductOrdersRepository extends CoreRepository
{
    private $ordersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ordersRepository = app(\App\Repositories\Admin\OrderRepository::class);
    }

    protected function getModelClass()
    {
        return ProductOrders::class;
    }

    public function addOrder($cnt, $price, $product_id, $product_title, $order_id)
    {
        $sum = $price * $cnt;
        $new_order = new ProductOrders();
        $new_order->order_id = $order_id;
        $new_order->product_id = $product_id;
        $new_order->qty = $cnt;
        $new_order->title = $product_title;
        $new_order->price = $price;
        $this->ordersRepository->updateSummary($order_id, $sum);
        return $new_order->save();
    }

    public function deleteProductFromOrder($id)
    {
        $order = $this->startConditions()
            ->where('id', $id)
            ->select('order_products.order_id', DB::raw('(order_products.price*order_products.qty) AS sum'))
            ->first();
        $sum = DB::table('orders')->where('id', $order->order_id)->select('orders.sum')->first();
        $sum = $sum->sum - $order->sum;
        DB::table('orders')
            ->where('id', $order->order_id)
            ->update(['sum' => $sum]);
        return $this->startConditions()
            ->find($id)
            ->forceDelete();
    }

    public function getProductsCountByOrderId($order_id)
    {
        return $this->startConditions()
            ->where('order_id', $order_id)
            ->count();
    }

}