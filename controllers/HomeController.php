<?php
namespace Controllers;

use Core\View;
use Models\Banner;
use Models\Category;
use Models\Product;
use Models\Vendor;

class HomeController
{
    public function index(): void
    {
        $bannerModel = new Banner();
        $categoryModel = new Category();
        $productModel = new Product();
        $vendorModel = new Vendor();

        View::make('home/index', [
            'banners' => $bannerModel->active(),
            'categories' => $categoryModel->all(),
            'popularProducts' => $productModel->latest(8),
            'premiumProducts' => $productModel->latest(12),
            'vendors' => $vendorModel->top(),
        ]);
    }
}
