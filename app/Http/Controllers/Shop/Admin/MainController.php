<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Repositories\Admin\MainRepository;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class MainController extends AdminBaseController
{
    private $orderRepository;
    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->orderRepository = app(OrderRepository::class);
        $this->productRepository = app(ProductRepository::class);
    }
    //admin panel index page with widgets
    public function index()
    {
        $countOrders = MainRepository::getCountOrders();
        $countUsers = MainRepository::getCountUsers();
        $countProducts = MainRepository::getCountProducts();
        $countCategories = MainRepository::getCountCategories();

        $paginatepages = 15;

        $last_orders = $this->orderRepository->getAllOrders($paginatepages+3);
        $last_products = $this->productRepository->getLastProducts($paginatepages);
        MetaTag::setTags(['title'=>'Admin Panel']);
        return view('shop.admin.main.index', compact('countUsers','countProducts',
            'countOrders','countCategories', 'last_products', 'last_orders'));
    }
}
