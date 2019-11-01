<?php


namespace App\Repositories\User;


class UserRepository
{
    private $orderRepository;
    private $userRepository;

    public function __construct()
    {
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
    }

    public function getUserOrders($id, $paginate){
        return $this->userRepository->getUserOrders($id,$paginate);
    }
    public function getCountOrders($id){
        return $this->userRepository->getCountOrders($id);
    }
    public function getCountOrdersPaginate($id,$paginate){
        return $this->userRepository->getCountOrdersPaginate($id,$paginate);
    }
    public function getUserOrder($id){
        return $this->orderRepository->getOneOrder(($this->orderRepository->getId($id))->id);
    }
    public function getAllUserOrderProducts($id){
        return $this->orderRepository->getAllOrderProductsId(($this->orderRepository->getId($id))->id);
    }

}