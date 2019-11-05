<?php


namespace App\Repositories\Main;


class MainRepository
{
    private $orderRepository;
    private $userRepository;
    private $categoryRepository;
    private $productRepository;
    private $currencyRepository;
    private $filterAttrsRepository;
    private $filterGroupRepository;


    public function __construct()
    {
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
        $this->categoryRepository = app(\App\Repositories\Admin\CategoryRepository::class);
        $this->productRepository = app(\App\Repositories\Admin\ProductRepository::class);
        $this->currencyRepository = app(\App\Repositories\Admin\CurrencyRepository::class);
        $this->filterAttrsRepository = app(\App\Repositories\Admin\FilterAttrsRepository::class);
        $this->filterGroupRepository = app(\App\Repositories\Admin\FilterGroupRepository::class);
    }
    public function getUserCountOrders($id){
       return $this->userRepository->getCountOrders($id);
    }
    public function buildMenu($menu){
       return $this->categoryRepository->buildMenu($menu);
    }
    public function getLastProducts($pag){
        return $this->productRepository->getLastAvailableProducts($pag);
    }
    public function getProductById($id){
        return $this->productRepository->getInfoProduct($id);
    }
    public function getFiltersProduct($id){
       return $this->productRepository->getFiltersProduct($id);
    }
    public function getRelatedProducts($id){
        return $this->productRepository->getRelatedProducts($id);
    }
    public function getGallery($id){
        return $this->productRepository->getGallery($id);
    }
    public function getBaseCurr(){
        return $this->currencyRepository->getBaseCurrency();
    }
    public function getAttributesProduct($id){
        $attr = $this->productRepository->getFiltersProduct($id);
        $filters = $this->filterAttrsRepository->getProductAttributeValues($attr);
        return $filters;
    }
    public function getAllFilterGroups(){
        return $this->filterGroupRepository->getAllGroupsFilter();
    }
}