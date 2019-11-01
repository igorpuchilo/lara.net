<?php


namespace App\Repositories\Main;


class MainRepository
{
    private $orderRepository;
    private $userRepository;
    private $categoryRepository;
    private $productRepository;

    public function __construct()
    {
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
        $this->categoryRepository = app(\App\Repositories\Admin\CategoryRepository::class);
        $this->productRepository = app(\App\Repositories\Admin\ProductRepository::class);
    }
    public function getUserCountOrders($id){
       return $this->userRepository->getCountOrders($id);
    }
    public function buildMenu($menu){
       return $this->categoryRepository->buildMenu($menu);
    }
    public function getLastProducts($pag){
        return $this->productRepository->getLastProducts($pag);
    }
}