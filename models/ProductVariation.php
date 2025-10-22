<?php
namespace Models;

use PDO;

class ProductVariation extends BaseModel
{
    public function forProduct(int $productId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_variations WHERE product_id = :product_id ORDER BY price ASC');
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_variations WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $variation = $stmt->fetch();
        return $variation ?: null;
    }

    public function create(int $productId, array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO product_variations (product_id, title, price, old_price, stock, sku)
            VALUES (:product_id, :title, :price, :old_price, :stock, :sku)');
        $stmt->execute([
            'product_id' => $productId,
            'title' => $data['title'],
            'price' => $data['price'],
            'old_price' => $data['old_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'sku' => $data['sku'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE product_variations SET title = :title, price = :price, old_price = :old_price,
            stock = :stock, sku = :sku WHERE id = :id');
        return $stmt->execute([
            'title' => $data['title'],
            'price' => $data['price'],
            'old_price' => $data['old_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'sku' => $data['sku'] ?? null,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM product_variations WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function sync(int $productId, array $variations): void
    {
        $existing = $this->forProduct($productId);
        $existingMap = [];
        foreach ($existing as $row) {
            $existingMap[$row['id']] = $row;
        }

        $seen = [];
        foreach ($variations as $payload) {
            if (!empty($payload['id']) && isset($existingMap[$payload['id']])) {
                $this->update((int)$payload['id'], $payload);
                $seen[] = (int)$payload['id'];
            } else {
                $newId = $this->create($productId, $payload);
                $seen[] = $newId;
            }
        }

        $toDelete = array_diff(array_keys($existingMap), $seen);
        if (!empty($toDelete)) {
            $stmt = $this->db->prepare('DELETE FROM product_variations WHERE id = :id');
            foreach ($toDelete as $id) {
                $stmt->execute(['id' => $id]);
            }
        }
    }

    public function deleteMissing(int $productId, array $keepIds): void
    {
        $sql = 'DELETE FROM product_variations WHERE product_id = ?';
        $params = [$productId];
        if (!empty($keepIds)) {
            $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
            $sql .= ' AND id NOT IN (' . $placeholders . ')';
            $params = array_merge($params, array_map('intval', $keepIds));
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    public function updateStock(int $id, int $stock): bool
    {
        $stmt = $this->db->prepare('UPDATE product_variations SET stock = :stock WHERE id = :id');
        return $stmt->execute(['stock' => $stock, 'id' => $id]);
    }

    public function totalStock(int $productId): int
    {
        $stmt = $this->db->prepare('SELECT SUM(stock) FROM product_variations WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $productId]);
        return (int)$stmt->fetchColumn();
    }
}
