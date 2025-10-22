<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Vendor;

class VendorsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $vendorModel = new Vendor();
        View::make('admin/vendors/index', [
            'vendors' => $vendorModel->all(),
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
            'name' => trim($_POST['name'] ?? ''),
            'rating' => (float)($_POST['rating'] ?? 5),
            'sales_count' => (int)($_POST['sales_count'] ?? 0),
        ];
        if (!$validator->validate($data, [
            'name' => 'required|min:3'
        ])) {
            Helpers::setFlash('admin', 'Satıcı kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/vendors'));
        }
        $vendorModel = new Vendor();
        $vendorModel->create($data);
        Helpers::setFlash('admin', 'Satıcı eklendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/vendors'));
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $validator = new Validator();
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'rating' => (float)($_POST['rating'] ?? 5),
            'sales_count' => (int)($_POST['sales_count'] ?? 0),
        ];
        if (!$validator->validate($data, [
            'name' => 'required|min:3'
        ])) {
            Helpers::setFlash('admin', 'Satıcı güncellenemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/vendors'));
        }
        $vendorModel = new Vendor();
        $vendorModel->update($id, $data);
        Helpers::setFlash('admin', 'Satıcı güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/vendors'));
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $vendorModel = new Vendor();
        $vendorModel->delete($id);
        Helpers::setFlash('admin', 'Satıcı silindi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/vendors'));
    }
}
