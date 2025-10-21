<?php
namespace Controllers;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Order;
use Models\Ticket;

class SupportController
{
    public function index(): void
    {
        $user = Auth::user();
        $orderModel = new Order();
        View::make('support/index', [
            'user' => $user,
            'orders' => $user ? $orderModel->forUser((int)$user['id'], 10) : [],
        ]);
    }

    public function create(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'subject' => 'required|min:6',
            'message' => 'required|min:10',
        ])) {
            Helpers::setFlash('support', 'Destek talebi oluşturulamadı.', 'error');
            Helpers::redirect(Helpers::baseUrl('support'));
        }

        $ticketModel = new Ticket();
        $ticketId = $ticketModel->create([
            'user_id' => Auth::user()['id'] ?? null,
            'order_id' => $_POST['order_id'] ?: null,
            'subject' => $_POST['subject'],
            'status' => 'open',
        ]);
        $ticketModel->addMessage($ticketId, Auth::user()['id'] ?? null, $_POST['message']);
        Helpers::setFlash('support', 'Destek talebiniz alınmıştır.', 'success');
        Helpers::redirect(Helpers::baseUrl('support'));
    }
}
