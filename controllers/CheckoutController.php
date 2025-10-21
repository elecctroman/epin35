<?php
namespace Controllers;

use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\Cart;
use Models\Order;
use Models\PaymentManager;
use Models\StockItem;

class CheckoutController
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
        View::make('checkout/index', [
            'cart' => $cart,
            'items' => $items,
            'step' => $_GET['step'] ?? 'cart',
        ]);
    }

    public function process(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        Helpers::session();
        $cart = $this->cartModel->findOrCreate(session_id(), $_SESSION['user_id'] ?? null);
        $items = $this->cartModel->items((int)$cart['id']);
        if (empty($items)) {
            Helpers::setFlash('checkout', 'Sepetiniz boş.', 'error');
            Helpers::redirect(Helpers::baseUrl('checkout'));
        }

        $paymentDriver = $_POST['payment_method'] ?? 'manual';
        $paymentManager = new PaymentManager();
        $driver = $paymentManager->driver($paymentDriver);
        $amount = array_sum(array_map(fn($item) => $item['qty'] * $item['unit_price'], $items));
        $charge = $driver->charge([
            'amount' => $amount,
            'customer_email' => $_POST['email'] ?? '',
        ]);

        $orderModel = new Order();
        $stockModel = new StockItem();
        $orderItems = [];

        foreach ($items as $item) {
            $orderItems[] = [
                'product_id' => $item['product_id'],
                'variation_id' => $item['variation_id'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'delivered_payload' => null,
            ];
        }

        $order = $orderModel->create([
            'user_id' => $_SESSION['user_id'] ?? null,
            'status' => $charge['status'] === 'paid' ? 'paid' : 'pending',
            'total' => $amount,
            'payment_method' => $paymentDriver,
            'payment_ref' => $charge['reference'],
        ], $orderItems);

        $pdo = require __DIR__ . '/../config/db.php';
        foreach ($order['item_ids'] as $index => $orderItemId) {
            $item = $items[$index];
            try {
                $codes = $stockModel->deliverToOrderItem((int)$item['variation_id'], (int)$item['qty'], $orderItemId);
            } catch (\Throwable $e) {
                $codes = ['Teslimat bekleniyor'];
            }
            $payload = json_encode(['codes' => $codes, 'delivered_at' => date('c')]);
            $update = $pdo->prepare('UPDATE order_items SET delivered_payload = :payload WHERE id = :id');
            $update->execute(['payload' => $payload, 'id' => $orderItemId]);
        }

        $this->cartModel->clear((int)$cart['id']);
        Helpers::setFlash('checkout', 'Siparişiniz alındı. Referans: ' . $charge['reference'], 'success');
        Helpers::redirect(Helpers::baseUrl('checkout?step=complete&order=' . $order['id']));
    }
}
