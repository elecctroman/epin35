<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\User;

class UsersController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $userModel = new User();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $filters = [
            'search' => trim($_GET['q'] ?? ''),
            'role' => $_GET['role'] ?? '',
        ];
        $total = $userModel->count($filters);
        $users = $userModel->paginate($filters, $perPage, ($page - 1) * $perPage);
        View::make('admin/users/index', [
            'users' => $users,
            'filters' => $filters,
            'pagination' => Helpers::pagination($total, $perPage, $page),
        ]);
    }

    public function updateRole(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $role = $_POST['role'] ?? 'user';
        $userModel = new User();
        $userModel->updateRole($id, $role);
        Helpers::setFlash('admin', 'Kullanıcı rolü güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/users'));
    }

    public function resetTwoFactor(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $userModel = new User();
        $userModel->resetTwoFactor($id);
        Helpers::setFlash('admin', '2FA sıfırlandı.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/users'));
    }
}
