<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;

class CouponsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $pdo = require __DIR__ . '/../../config/db.php';
        $coupons = $pdo->query('SELECT * FROM coupons ORDER BY created_at DESC')->fetchAll();
        View::make('admin/coupons/index', [
            'coupons' => $coupons
        ]);
    }

    public function store(): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'code' => 'required|min:4',
            'type' => 'required',
            'value' => 'required'
        ])) {
            Helpers::setFlash('admin', 'Kupon kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/coupons'));
        }
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->prepare('INSERT INTO coupons (code, type, value, min_total, starts_at, ends_at, usage_limit, created_at) VALUES (:code, :type, :value, :min_total, :starts_at, :ends_at, :usage_limit, NOW())');
        $stmt->execute([
            'code' => $_POST['code'],
            'type' => $_POST['type'],
            'value' => $_POST['value'],
            'min_total' => $_POST['min_total'] ?: null,
            'starts_at' => $_POST['starts_at'],
            'ends_at' => $_POST['ends_at'],
            'usage_limit' => $_POST['usage_limit'] ?: null,
        ]);
        Helpers::setFlash('admin', 'Kupon oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/coupons'));
    }
}
