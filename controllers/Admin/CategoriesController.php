<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Category;

class CategoriesController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $categoryModel = new Category();
        View::make('admin/categories/index', [
            'categories' => $categoryModel->all()
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
            'name' => 'required|min:3',
            'slug' => 'required|min:3'
        ])) {
            Helpers::setFlash('admin', 'Kategori kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/categories'));
        }
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->prepare('INSERT INTO categories (parent_id, name, slug, sort) VALUES (:parent_id, :name, :slug, :sort)');
        $stmt->execute([
            'parent_id' => $_POST['parent_id'] ?: null,
            'name' => $_POST['name'],
            'slug' => $_POST['slug'],
            'sort' => (int)($_POST['sort'] ?? 0),
        ]);
        Helpers::setFlash('admin', 'Kategori oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/categories'));
    }
}
