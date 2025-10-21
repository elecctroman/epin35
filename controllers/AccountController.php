<?php
namespace Controllers;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Order;
use Models\Ticket;

class AccountController
{
    public function index(): void
    {
        $user = Auth::user();
        if (!$user) {
            Helpers::redirect(Helpers::baseUrl('login'));
        }
        $orderModel = new Order();
        $ticketModel = new Ticket();
        View::make('account/index', [
            'user' => $user,
            'orders' => $orderModel->forUser((int)$user['id'], 5),
            'tickets' => $ticketModel->forUser((int)$user['id'])
        ]);
    }

    public function loginForm(): void
    {
        View::make('account/login');
    }

    public function login(): void
    {
        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ])) {
            Helpers::setFlash('auth', 'Geçersiz giriş bilgileri.', 'error');
            Helpers::redirect(Helpers::baseUrl('login'));
        }
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        if (Auth::attempt($_POST['email'], $_POST['password'])) {
            Helpers::redirect(Helpers::baseUrl('account'));
        }
        Helpers::setFlash('auth', 'E-posta veya şifre hatalı.', 'error');
        Helpers::redirect(Helpers::baseUrl('login'));
    }

    public function logout(): void
    {
        Auth::logout();
        Helpers::redirect(Helpers::baseUrl('/'));
    }
}
