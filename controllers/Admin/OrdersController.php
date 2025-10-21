<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\Order;

class OrdersController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();
        View::make('admin/orders/index', [
            'orders' => $orderModel->recent(50)
        ]);
    }
}
