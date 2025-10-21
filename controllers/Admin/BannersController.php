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
            'banners' => $bannerModel->active()
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
            'title' => 'required|min:3',
            'image' => 'required',
        ])) {
            Helpers::setFlash('admin', 'Banner kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/banners'));
        }
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->prepare('INSERT INTO banners (title, image, url, sort, is_active) VALUES (:title, :image, :url, :sort, :is_active)');
        $stmt->execute([
            'title' => $_POST['title'],
            'image' => $_POST['image'],
            'url' => $_POST['url'] ?? '#',
            'sort' => (int)($_POST['sort'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        Helpers::setFlash('admin', 'Banner oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/banners'));
    }
}
