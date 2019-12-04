<?php


namespace App\Repositories\User;


use DB;

class UserRepository
{
    private $orderRepository;
    private $userRepository;
    private $productOrdersRepository;
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(\App\Repositories\Admin\CategoryRepository::class);
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
        $this->productOrdersRepository = app(\App\Repositories\Admin\ProductOrdersRepository::class);
    }

    public function getUserOrders($id, $paginate){
        return $this->userRepository->getUserOrders($id,$paginate);
    }
    public function getCountOrders($id){
        return $this->productOrdersRepository->getProductsCountByOrderId($this->orderRepository->getOrderIdByUserID($id));
    }
    public function getCountOrdersPaginate($id,$paginate){
        return $this->userRepository->getCountOrdersPaginate($id,$paginate);
    }
    public function getUserOrder($id){
        $order_id = $this->orderRepository->getOrderIdByUserID($id);
        if($order_id){
            return $this->orderRepository->getUserOrder($order_id);
        }
        return false;
    }
    public function getUserOrderHistory($id){
        return $this->orderRepository->getOrderHistoryByUserId($id);
    }
    public function getAllUserOrderProducts($id){
        return  $this->orderRepository->getAllOrderProductsId($id);
    }
    public function deleteProductFromOrder($id){
        return $this->productOrdersRepository->deleteProductFromOrder($id);
    }
    public function saveOrder($id){
        return $this->orderRepository->saveOrderComment($id);
    }
    public function AddOrder($user_id,$cnt,$price,$product_id,$product_title){
        $order_id = $this->orderRepository->getOrderIdByUserID($user_id);
        DB::table('orders')->where('id',$order_id)->update(['status' => '3']);
        return $this->productOrdersRepository->addOrder($cnt,$price,$product_id,$product_title,$order_id);
    }
    public function buildMenu($menu){
        return $this->categoryRepository->buildMenu($menu);
    }

}