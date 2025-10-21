<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\User;

class UsersController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->query('SELECT id, email, name, role, created_at FROM users ORDER BY created_at DESC LIMIT 100');
        View::make('admin/users/index', [
            'users' => $stmt->fetchAll()
        ]);
    }
}
