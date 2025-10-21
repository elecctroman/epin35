<?php
namespace Models;

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
}
