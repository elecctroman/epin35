<?php
namespace Controllers;

use Core\Helpers;
use Core\View;
use Models\Category;
use Models\Product;
use Models\ProductVariation;

class ProductController
{
    public function show(string $slug): void
    {
        $productModel = new Product();
        $variationModel = new ProductVariation();
        $categoryModel = new Category();
        $product = $productModel->findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            View::make('errors/404');
            return;
        }
        $variations = $variationModel->forProduct((int)$product['id']);

        View::make('product/show', [
            'product' => $product,
            'variations' => $variations,
            'categories' => $categoryModel->all(),
        ]);
    }
}
