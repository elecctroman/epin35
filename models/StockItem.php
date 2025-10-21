<?php
namespace Models;

class StockItem extends BaseModel
{
    public function deliverToOrderItem(int $variationId, int $quantity, int $orderItemId): array
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('SELECT id, code_plain_encrypted FROM stock_items WHERE variation_id = :variation_id AND is_sold = 0 LIMIT :qty FOR UPDATE');
            $stmt->bindValue(':variation_id', $variationId, \PDO::PARAM_INT);
            $stmt->bindValue(':qty', $quantity, \PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll();
            if (count($items) < $quantity) {
                $this->db->rollBack();
                throw new \RuntimeException('Stok yetersiz');
            }
            $ids = array_column($items, 'id');
            $in = implode(',', array_fill(0, count($ids), '?'));
            $update = $this->db->prepare("UPDATE stock_items SET is_sold = 1, sold_at = NOW(), order_item_id = ? WHERE id IN ({$in})");
            $update->execute(array_merge([$orderItemId], $ids));
            $this->db->commit();
            return array_map(fn($row) => $row['code_plain_encrypted'], $items);
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}
