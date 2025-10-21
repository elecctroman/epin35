<?php
namespace Controllers;

use Core\View;
use Models\Product;

class SearchController
{
    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');
        $productModel = new Product();
        $products = $query === '' ? [] : $productModel->search($query);
        View::make('search/index', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
