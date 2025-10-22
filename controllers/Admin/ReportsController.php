<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\Order;
use Models\Product;

class ReportsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();
        $productModel = new Product();
        $pdo = require __DIR__ . '/../../config/db.php';

        $paymentBreakdown = $pdo->query('SELECT payment_method, COUNT(*) AS total_orders, SUM(total) AS total_amount FROM orders GROUP BY payment_method')->fetchAll();
        $daily = $orderModel->revenueTimeline(30);
        $status = $orderModel->statusBreakdown();
        $topProducts = $productModel->topSelling(10);

        View::make('admin/reports/index', [
            'dailySales' => $daily,
            'status' => $status,
            'payments' => $paymentBreakdown,
            'topProducts' => $topProducts,
        ]);
    }
}
