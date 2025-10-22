<?php
namespace Controllers;

use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\Cart;
use Models\Product;
use Models\ProductVariation;

class CartController
{
    private Cart $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    public function index(): void
    {
        Helpers::session();
        $cart = $this->cartModel->findOrCreate(session_id(), $_SESSION['user_id'] ?? null);
        $items = $this->cartModel->items((int)$cart['id']);
        $productModel = new Product();
        View::make('cart/index', [
            'cart' => $cart,
            'items' => $items,
            'recommendations' => $productModel->latest(4),
        ]);
    }

    public function add(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $productId = (int)($_POST['product_id'] ?? 0);
        $variationId = (int)($_POST['variation_id'] ?? 0);
        $qty = max(1, (int)($_POST['qty'] ?? 1));

        $variationModel = new ProductVariation();
        $variation = $variationModel->find($variationId);
        if (!$variation || (int)$variation['product_id'] !== $productId) {
            Helpers::setFlash('cart', 'Ürün varyantı bulunamadı.', 'error');
            Helpers::redirect(Helpers::baseUrl('cart'));
        }

        Helpers::session();
        $cart = $this->cartModel->findOrCreate(session_id(), $_SESSION['user_id'] ?? null);
        $this->cartModel->addItem((int)$cart['id'], $productId, $variationId, $qty, (float)$variation['price']);
        Helpers::setFlash('cart', 'Ürün sepetinize eklendi.', 'success');
        Helpers::redirect($_SERVER['HTTP_REFERER'] ?? Helpers::baseUrl('cart'));
    }

    public function remove(int $itemId): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        Helpers::session();
        $cart = $this->cartModel->findOrCreate(session_id(), $_SESSION['user_id'] ?? null);
        $this->cartModel->removeItem((int)$cart['id'], $itemId);
        Helpers::setFlash('cart', 'Ürün sepetten kaldırıldı.', 'info');
        Helpers::redirect(Helpers::baseUrl('cart'));
    }
}
