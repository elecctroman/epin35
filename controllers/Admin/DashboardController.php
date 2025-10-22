<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\Order;
use Models\Product;
use Models\StockItem;
use Models\Ticket;

class DashboardController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();
        $productModel = new Product();
        $stockModel = new StockItem();
        $ticketModel = new Ticket();

        $metrics = $orderModel->metrics();
        $metrics['stock_alerts'] = $stockModel->lowStockCount(5);

        View::make('admin/dashboard/index', [
            'orders' => $orderModel->recent(8),
            'metrics' => $metrics,
            'timeline' => $orderModel->revenueTimeline(10),
            'statusBreakdown' => $orderModel->statusBreakdown(),
            'topProducts' => $productModel->topSelling(5),
            'tickets' => $ticketModel->paginate(['status' => 'open'], 5, 0),
        ]);
    }
}
