<?php
namespace Models;

class Product extends BaseModel
{
    public function latest(int $limit = 12): array
    {
        $stmt = $this->db->prepare('SELECT p.*, c.name AS category_name, c.slug AS category_slug FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.is_active = 1 ORDER BY p.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function byCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE category_id = :category_id AND is_active = 1 ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function search(string $query, int $limit = 30): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE (name LIKE :like OR description LIKE :like) AND is_active = 1 ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':like', '%' . $query . '%');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
