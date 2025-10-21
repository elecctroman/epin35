<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Category;
use Models\Product;

class ProductsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $productModel = new Product();
        View::make('admin/products/index', [
            'products' => $productModel->latest(100)
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();
        $categoryModel = new Category();
        View::make('admin/products/create', [
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
            'name' => 'required|min:4',
            'slug' => 'required|min:4',
            'description' => 'required|min:10'
        ])) {
            Helpers::setFlash('admin', 'Ürün kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/products/create'));
        }
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->prepare('INSERT INTO products (category_id, name, slug, description, cover, is_active, created_at) VALUES (:category_id, :name, :slug, :description, :cover, :is_active, NOW())');
        $stmt->execute([
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'slug' => $_POST['slug'],
            'description' => $_POST['description'],
            'cover' => $_POST['cover'] ?? '',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        Helpers::setFlash('admin', 'Ürün oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/products'));
    }
}
