<?php
namespace Models;

class Order extends BaseModel
{
    public function create(array $data, array $items): array
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO orders (user_id, status, total, payment_method, payment_ref, created_at) VALUES (:user_id, :status, :total, :payment_method, :payment_ref, NOW())');
            $stmt->execute([
                'user_id' => $data['user_id'],
                'status' => $data['status'],
                'total' => $data['total'],
                'payment_method' => $data['payment_method'],
                'payment_ref' => $data['payment_ref']
            ]);
            $orderId = (int)$this->db->lastInsertId();

            $itemIds = [];
            $itemStmt = $this->db->prepare('INSERT INTO order_items (order_id, product_id, variation_id, qty, unit_price, delivered_payload) VALUES (:order_id, :product_id, :variation_id, :qty, :unit_price, :delivered_payload)');
            foreach ($items as $item) {
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'variation_id' => $item['variation_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'delivered_payload' => $item['delivered_payload'] ?? null,
                ]);
                $itemIds[] = (int)$this->db->lastInsertId();
            }
            $this->db->commit();
            return ['id' => $orderId, 'item_ids' => $itemIds];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function recent(int $limit = 10): array
    {
        $stmt = $this->db->prepare('SELECT o.*, u.email FROM orders o LEFT JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function forUser(int $userId, int $limit = 10): array
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
