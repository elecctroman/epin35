<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;

class ReportsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $pdo = require __DIR__ . '/../../config/db.php';
        $salesDaily = $pdo->query('SELECT DATE(created_at) as day, SUM(total) as total FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY day ORDER BY day ASC')->fetchAll();
        View::make('admin/reports/index', [
            'salesDaily' => $salesDaily,
        ]);
    }
}
