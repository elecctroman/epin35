<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\Order;

class OrdersController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $filters = [
            'status' => $_GET['status'] ?? '',
            'search' => trim($_GET['q'] ?? ''),
        ];
        $total = $orderModel->count($filters);
        $orders = $orderModel->paginate($filters, $perPage, ($page - 1) * $perPage);

        View::make('admin/orders/index', [
            'orders' => $orders,
            'filters' => $filters,
            'pagination' => Helpers::pagination($total, $perPage, $page),
        ]);
    }

    public function show(int $id): void
    {
        Auth::requireAdmin();
        $orderModel = new Order();
        $order = $orderModel->find($id);
        if (!$order) {
            http_response_code(404);
            exit('Sipariş bulunamadı');
        }
        View::make('admin/orders/show', [
            'order' => $order,
        ]);
    }

    public function updateStatus(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $status = $_POST['status'] ?? 'pending';
        $orderModel = new Order();
        $orderModel->updateStatus($id, $status);
        Helpers::setFlash('admin', 'Sipariş durumu güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/orders/' . $id));
    }
}
