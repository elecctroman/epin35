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
            'categories' => $categoryModel->all(),
            'tree' => $categoryModel->tree(),
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
            'slug' => trim($_POST['slug'] ?? ''),
            'parent_id' => (int)($_POST['parent_id'] ?? 0),
            'sort' => (int)($_POST['sort'] ?? 0),
        ];
        if (!$validator->validate($data, [
            'name' => 'required|min:3',
            'slug' => 'required|min:3'
        ])) {
            Helpers::setFlash('admin', 'Kategori kaydedilemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/categories'));
        }
        $categoryModel = new Category();
        $categoryModel->create($data);
        Helpers::setFlash('admin', 'Kategori oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/categories'));
    }

    public function edit(int $id): void
    {
        Auth::requireAdmin();
        $categoryModel = new Category();
        $category = $categoryModel->find($id);
        if (!$category) {
            http_response_code(404);
            exit('Kategori bulunamadı');
        }
        View::make('admin/categories/edit', [
            'category' => $category,
            'categories' => $categoryModel->options($id),
        ]);
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $categoryModel = new Category();
        $category = $categoryModel->find($id);
        if (!$category) {
            http_response_code(404);
            exit('Kategori bulunamadı');
        }
        $validator = new Validator();
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'parent_id' => (int)($_POST['parent_id'] ?? 0),
            'sort' => (int)($_POST['sort'] ?? 0),
        ];
        if (!$validator->validate($data, [
            'name' => 'required|min:3',
            'slug' => 'required|min:3'
        ])) {
            Helpers::setFlash('admin', 'Kategori güncellenemedi.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/categories/' . $id . '/edit'));
        }
        $categoryModel->update($id, $data);
        Helpers::setFlash('admin', 'Kategori güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/categories'));
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $categoryModel = new Category();
        $categoryModel->delete($id);
        Helpers::setFlash('admin', 'Kategori silindi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/categories'));
    }
}
