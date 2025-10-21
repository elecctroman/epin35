<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\Order;
use Models\Product;
use Models\StockItem;

class DashboardController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();
        $productModel = new Product();
        $stockModel = new StockItem();

        View::make('admin/dashboard/index', [
            'orders' => $orderModel->recent(8),
            'metrics' => [
                'today_sales' => 0,
                'active_products' => count($productModel->latest(100)),
                'stock_alerts' => 0,
            ]
        ]);
    }
}
