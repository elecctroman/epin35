<?php
namespace Controllers;

use Core\View;
use Models\Banner;
use Models\Category;
use Models\Order;
use Models\Product;
use Models\Vendor;

class HomeController
{
    public function index(): void
    {
        $bannerModel = new Banner();
        $categoryModel = new Category();
        $productModel = new Product();
        $orderModel = new Order();
        $vendorModel = new Vendor();

        View::make('home/index', [
            'banners' => $bannerModel->active(),
            'categories' => $categoryModel->all(),
            'popularProducts' => $productModel->latest(8),
            'premiumProducts' => $productModel->premium(8),
            'vendors' => $vendorModel->top(),
            'storeMetrics' => $orderModel->metrics(),
            'revenueSparkline' => $orderModel->revenueTimeline(7),
        ]);
    }
}
