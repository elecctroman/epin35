<?php
namespace Models;

use PDO;

class Vendor extends BaseModel
{
    public function top(int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT * FROM vendors ORDER BY rating DESC, sales_count DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM vendors ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM vendors WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $vendor = $stmt->fetch();
        return $vendor ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO vendors (name, rating, sales_count) VALUES (:name, :rating, :sales_count)');
        $stmt->execute([
            'name' => $data['name'],
            'rating' => $data['rating'] ?? 5.0,
            'sales_count' => $data['sales_count'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE vendors SET name = :name, rating = :rating, sales_count = :sales_count WHERE id = :id');
        return $stmt->execute([
            'name' => $data['name'],
            'rating' => $data['rating'] ?? 5.0,
            'sales_count' => $data['sales_count'] ?? 0,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM vendors WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
