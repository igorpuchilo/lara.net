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
    private $productOrdersRepository;


    public function __construct()
    {
        $this->orderRepository = app(\App\Repositories\Admin\OrderRepository::class);
        $this->userRepository = app(\App\Repositories\Admin\UserRepository::class);
        $this->categoryRepository = app(\App\Repositories\Admin\CategoryRepository::class);
        $this->productRepository = app(\App\Repositories\Admin\ProductRepository::class);
        $this->currencyRepository = app(\App\Repositories\Admin\CurrencyRepository::class);
        $this->filterAttrsRepository = app(\App\Repositories\Admin\FilterAttrsRepository::class);
        $this->filterGroupRepository = app(\App\Repositories\Admin\FilterGroupRepository::class);
        $this->productOrdersRepository = app(\App\Repositories\Admin\ProductOrdersRepository::class);
    }
    public function getUserCountOrders($id){
       return $this->productOrdersRepository->getProductsCountByOrderId($this->orderRepository->getOrderIdByUserID($id));
    }
    public function buildMenu($menu){
       return $this->categoryRepository->buildMenu($menu);
    }
    public function getLastProducts($pag){
        return $this->productRepository->getLastAvailableProducts($pag);
    }
    public function getProductByAlias($alias){
        return $this->productRepository->getProductByAlias($alias);
    }
    public function getProductById($id){
        return $this->productRepository->getInfoProduct($id);
    }
    public function getFiltersProduct($id){
       return $this->productRepository->getFiltersProduct($id);
    }
    public function getRelatedProducts($id,$lim){
        return $this->productRepository->getRelatedProductsList($id,$lim);
    }
    public function getGallery($id){
        return $this->productRepository->getGallery($id);
    }
    public function getBaseCurr(){
        return $this->currencyRepository->getBaseCurrency();
    }
    public function getAttributesProduct($id){
        $attr = $this->productRepository->getFiltersProduct($id);
        return $attr;
    }
    public function getAllAttributes(){
        return $this->filterAttrsRepository->getAllAttrsValues();
    }
    public function getAllFilterGroups($paginate){
        return $this->filterGroupRepository->getAllGroupsFilter($paginate);
    }
    public function getProductsByCategoryId($id,$paginate){
        return $this->productRepository->getProductsByCatId($id,$paginate);
    }
    public function getCategoryById($id){
        return $this->categoryRepository->getId($id);
    }
    public function getCategoryByAlias($alias){
        return $this->categoryRepository->getCategoryByAlias($alias);
    }
    public function getSearchResult($query,$paginate){
        return $this->productRepository->getSearchResult($query,$paginate);
    }
    public function getAutocompleteByTerms($term){
        return $this->productRepository->getAutocompleteByTerms($term);
    }
    public function getFiltersByAttrs($attrs){
        return $this->filterGroupRepository->getFiltersByAttrs($attrs);
    }
    public function getProductsByAttrsAndCat($attrs,$paginate,$id){
        return $this->productRepository->getProductsByAttrsAndCat($attrs,$paginate,$id);
    }
    public function getAllAttributesByGroupsId($groups){
       return $this->filterAttrsRepository->getAllAttributesByGroupsId($groups);
    }
    public function getAllFilterGroupsByParentId($id){
        return $this->filterGroupRepository->getAllFilterGroupsByParentId($id);
    }
}