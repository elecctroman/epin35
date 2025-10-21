<?php
namespace Models;

class Category extends BaseModel
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY sort ASC');
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $category = $stmt->fetch();
        return $category ?: null;
    }
}
