<?php
namespace Models;

use PDO;

class StockItem extends BaseModel
{
    public function deliverToOrderItem(int $variationId, int $quantity, int $orderItemId): array
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('SELECT id, code_plain_encrypted FROM stock_items WHERE variation_id = :variation_id AND is_sold = 0 LIMIT :qty FOR UPDATE');
            $stmt->bindValue(':variation_id', $variationId, PDO::PARAM_INT);
            $stmt->bindValue(':qty', $quantity, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll();
            if (count($items) < $quantity) {
                $this->db->rollBack();
                throw new \RuntimeException('Stok yetersiz');
            }
            $ids = array_column($items, 'id');
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $update = $this->db->prepare("UPDATE stock_items SET is_sold = 1, sold_at = NOW(), order_item_id = ? WHERE id IN ({$placeholders})");
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

    public function countForVariation(int $variationId, bool $onlyAvailable = false): int
    {
        $sql = 'SELECT COUNT(*) FROM stock_items WHERE variation_id = :variation_id';
        if ($onlyAvailable) {
            $sql .= ' AND is_sold = 0';
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['variation_id' => $variationId]);
        return (int)$stmt->fetchColumn();
    }

    public function lowStockCount(int $threshold = 3): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(DISTINCT variation_id) FROM stock_items WHERE is_sold = 0 GROUP BY variation_id HAVING COUNT(*) <= :threshold');
        $stmt->bindValue(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return count($rows);
    }

    public function listForVariation(int $variationId, int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare('SELECT * FROM stock_items WHERE variation_id = :variation_id ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':variation_id', $variationId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function importBulk(int $variationId, array $codes): int
    {
        $stmt = $this->db->prepare('INSERT INTO stock_items (variation_id, code_hash, code_plain_encrypted, is_sold) VALUES (:variation_id, :code_hash, :code_plain_encrypted, 0)');
        $imported = 0;
        foreach ($codes as $code) {
            $clean = trim($code);
            if ($clean === '') {
                continue;
            }
            $stmt->execute([
                'variation_id' => $variationId,
                'code_hash' => hash('sha256', $clean . microtime(true)),
                'code_plain_encrypted' => base64_encode($clean),
            ]);
            $imported++;
        }
        return $imported;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM stock_items WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
