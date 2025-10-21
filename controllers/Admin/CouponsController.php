<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Coupon;

class CouponsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $couponModel = new Coupon();
        View::make('admin/coupons/index', [
            'coupons' => $couponModel->all(),
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
        $data = [
            'code' => trim($_POST['code'] ?? ''),
            'type' => $_POST['type'] ?? 'percent',
            'value' => (float)($_POST['value'] ?? 0),
            'min_total' => $_POST['min_total'] !== '' ? (float)$_POST['min_total'] : null,
            'starts_at' => $_POST['starts_at'] ?? '',
            'ends_at' => $_POST['ends_at'] ?? '',
            'usage_limit' => $_POST['usage_limit'] !== '' ? (int)$_POST['usage_limit'] : null,
        ];
        if (!$validator->validate($data, [
            'code' => 'required|min:4',
            'type' => 'required',
            'value' => 'required'
        ])) {
            Helpers::setFlash('admin', 'Kupon kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/coupons'));
        }
        $couponModel = new Coupon();
        $couponModel->create($data);
        Helpers::setFlash('admin', 'Kupon oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/coupons'));
    }

    public function edit(int $id): void
    {
        Auth::requireAdmin();
        $couponModel = new Coupon();
        $coupon = $couponModel->find($id);
        if (!$coupon) {
            http_response_code(404);
            exit('Kupon bulunamadı');
        }
        View::make('admin/coupons/edit', [
            'coupon' => $coupon,
        ]);
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $couponModel = new Coupon();
        $coupon = $couponModel->find($id);
        if (!$coupon) {
            http_response_code(404);
            exit('Kupon bulunamadı');
        }
        $validator = new Validator();
        $data = [
            'code' => trim($_POST['code'] ?? ''),
            'type' => $_POST['type'] ?? 'percent',
            'value' => (float)($_POST['value'] ?? 0),
            'min_total' => $_POST['min_total'] !== '' ? (float)$_POST['min_total'] : null,
            'starts_at' => $_POST['starts_at'] ?? '',
            'ends_at' => $_POST['ends_at'] ?? '',
            'usage_limit' => $_POST['usage_limit'] !== '' ? (int)$_POST['usage_limit'] : null,
        ];
        if (!$validator->validate($data, [
            'code' => 'required|min:4',
            'type' => 'required',
            'value' => 'required'
        ])) {
            Helpers::setFlash('admin', 'Kupon güncellenemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/coupons/' . $id . '/edit'));
        }
        $couponModel->update($id, $data);
        Helpers::setFlash('admin', 'Kupon güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/coupons'));
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $couponModel = new Coupon();
        $couponModel->delete($id);
        Helpers::setFlash('admin', 'Kupon silindi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/coupons'));
    }
}
