<?php
namespace Models;

class Category extends BaseModel
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY sort ASC, name ASC');
        return $stmt->fetchAll();
    }

    public function featured(int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories ORDER BY sort ASC, name ASC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function tree(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY COALESCE(parent_id, 0), sort ASC, name ASC');
        $rows = $stmt->fetchAll();
        $grouped = [];
        foreach ($rows as $row) {
            $parent = $row['parent_id'] ?? 0;
            $grouped[$parent][] = $row;
        }
        $builder = function ($parentId) use (&$builder, $grouped) {
            $items = $grouped[$parentId] ?? [];
            foreach ($items as &$item) {
                $item['children'] = $builder($item['id']);
            }
            return $items;
        };
        return $builder(0);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO categories (parent_id, name, slug, sort) VALUES (:parent_id, :name, :slug, :sort)');
        $stmt->execute([
            'parent_id' => $data['parent_id'] ?: null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'sort' => $data['sort'] ?? 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE categories SET parent_id = :parent_id, name = :name, slug = :slug, sort = :sort WHERE id = :id');
        return $stmt->execute([
            'parent_id' => $data['parent_id'] ?: null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'sort' => $data['sort'] ?? 0,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function options(int $exclude = 0): array
    {
        $stmt = $this->db->prepare('SELECT id, name FROM categories WHERE id <> :exclude ORDER BY name ASC');
        $stmt->execute(['exclude' => $exclude]);
        return $stmt->fetchAll();
    }
}
