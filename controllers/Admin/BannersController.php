<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Banner;

class BannersController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $bannerModel = new Banner();
        View::make('admin/banners/index', [
            'banners' => $bannerModel->all(),
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
            'title' => trim($_POST['title'] ?? ''),
            'image' => $_POST['image'] ?? '',
            'url' => $_POST['url'] ?? '#',
            'sort' => (int)($_POST['sort'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if (!$validator->validate($data, [
            'title' => 'required|min:3',
            'image' => 'required',
        ])) {
            Helpers::setFlash('admin', 'Banner kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/banners'));
        }
        $bannerModel = new Banner();
        $bannerModel->create($data);
        Helpers::setFlash('admin', 'Banner oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/banners'));
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $bannerModel = new Banner();
        $banner = $bannerModel->find($id);
        if (!$banner) {
            http_response_code(404);
            exit('Banner bulunamadı');
        }
        $validator = new Validator();
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'image' => $_POST['image'] ?? '',
            'url' => $_POST['url'] ?? '#',
            'sort' => (int)($_POST['sort'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if (!$validator->validate($data, [
            'title' => 'required|min:3',
            'image' => 'required',
        ])) {
            Helpers::setFlash('admin', 'Banner güncellenemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/banners'));
        }
        $bannerModel->update($id, $data);
        Helpers::setFlash('admin', 'Banner güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/banners'));
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $bannerModel = new Banner();
        $bannerModel->delete($id);
        Helpers::setFlash('admin', 'Banner silindi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/banners'));
    }
}
