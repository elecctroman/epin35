<?php
namespace Controllers;

use Core\View;
use Models\Category;
use Models\Product;

class CategoryController
{
    public function show(string $slug): void
    {
        $categoryModel = new Category();
        $productModel = new Product();
        $category = $categoryModel->findBySlug($slug);
        if (!$category) {
            http_response_code(404);
            View::make('errors/404');
            return;
        }
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        $products = $productModel->byCategory((int)$category['id'], $limit, $offset);
        View::make('category/show', [
            'category' => $category,
            'products' => $products,
            'page' => $page,
        ]);
    }
}
