<?php
namespace Models;

class Cart extends BaseModel
{
    public function findOrCreate(string $sessionId, ?int $userId = null): array
    {
        $stmt = $this->db->prepare('SELECT * FROM carts WHERE session_id = :session_id');
        $stmt->execute(['session_id' => $sessionId]);
        $cart = $stmt->fetch();
        if ($cart) {
            return $cart;
        }
        $stmt = $this->db->prepare('INSERT INTO carts (user_id, session_id, created_at, updated_at) VALUES (:user_id, :session_id, NOW(), NOW())');
        $stmt->execute([
            'user_id' => $userId,
            'session_id' => $sessionId
        ]);
        return $this->findOrCreate($sessionId, $userId);
    }

    public function items(int $cartId): array
    {
        $stmt = $this->db->prepare('SELECT ci.*, p.name AS product_name, pv.title AS variation_title FROM cart_items ci JOIN products p ON p.id = ci.product_id JOIN product_variations pv ON pv.id = ci.variation_id WHERE ci.cart_id = :cart_id');
        $stmt->execute(['cart_id' => $cartId]);
        return $stmt->fetchAll();
    }

    public function addItem(int $cartId, int $productId, int $variationId, int $qty, float $unitPrice): void
    {
        $stmt = $this->db->prepare('INSERT INTO cart_items (cart_id, product_id, variation_id, qty, unit_price) VALUES (:cart_id, :product_id, :variation_id, :qty, :unit_price) ON DUPLICATE KEY UPDATE qty = qty + VALUES(qty)');
        $stmt->execute([
            'cart_id' => $cartId,
            'product_id' => $productId,
            'variation_id' => $variationId,
            'qty' => $qty,
            'unit_price' => $unitPrice
        ]);
    }

    public function removeItem(int $cartId, int $itemId): void
    {
        $stmt = $this->db->prepare('DELETE FROM cart_items WHERE cart_id = :cart_id AND id = :id');
        $stmt->execute(['cart_id' => $cartId, 'id' => $itemId]);
    }

    public function clear(int $cartId): void
    {
        $stmt = $this->db->prepare('DELETE FROM cart_items WHERE cart_id = :cart_id');
        $stmt->execute(['cart_id' => $cartId]);
    }
}
