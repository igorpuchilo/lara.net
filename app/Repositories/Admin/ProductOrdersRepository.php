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
    public function addOrder($cnt,$price,$product_id,$product_title,$order_id){
        $sum = $price*$cnt;
        $new_order = new ProductOrders();
        $new_order->order_id = $order_id;
        $new_order->product_id = $product_id;
        $new_order->qty = $cnt;
        $new_order->title = $product_title;
        $new_order->price = $sum;
        $this->ordersRepository->updateSummary($order_id,$sum);
        return $new_order->save();
    }
    public function deleteProductFromOrder($id){
        return $this->startConditions()
            ->find($id)
            ->forceDelete();
    }

}