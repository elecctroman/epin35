<?php
namespace Controllers;

use Core\Helpers;
use Core\View;
use Models\Category;
use Models\Product;
use Models\ProductVariation;
use Models\Vendor;

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
        $productId = (int)$product['id'];
        $variations = $variationModel->forProduct($productId);
        $related = [];
        $vendorModel = new Vendor();
        $preferredVendors = $vendorModel->top(3);
        if (!empty($product['category_id'])) {
            $related = $productModel->similar((int)$product['category_id'], $productId, 4);
        }

        View::make('product/show', [
            'product' => $product,
            'variations' => $variations,
            'relatedProducts' => $related,
            'categories' => $categoryModel->all(),
            'preferredVendors' => $preferredVendors,
        ]);
    }
}
