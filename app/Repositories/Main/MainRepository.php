<?php


namespace App\Repositories\Main;


class MainRepository
{
    private $orderRepository;
    private $productOrdersRepository;


    public function __construct()
    {
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->productOrdersRepository = app(\App\Repositories\Admin\ProductOrdersRepository::class);
    }
    public function getUserCountOrders($id){
        $order_id = $this->orderRepository->getOrderIdByUserID($id);
       if($order_id) {
           return $this->productOrdersRepository->getProductsCountByOrderId($order_id);
       }else return 0;
    }
}