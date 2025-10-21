<?php
namespace Models;

use PDO;

class Product extends BaseModel
{
    public function latest(int $limit = 12): array
    {
        $stmt = $this->db->prepare('SELECT p.*, c.name AS category_name, c.slug AS category_slug, MIN(v.price) AS min_price
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN product_variations v ON v.product_id = p.id
            WHERE p.is_active = 1
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function premium(int $limit = 12): array
    {
        $stmt = $this->db->prepare('SELECT p.*, MIN(v.price) AS min_price
            FROM products p
            LEFT JOIN product_variations v ON v.product_id = p.id
            WHERE p.is_active = 1
            ORDER BY v.price ASC
            LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function findWithRelations(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        if (!$product) {
            return null;
        }
        $variationModel = new ProductVariation();
        $product['variations'] = $variationModel->forProduct($id);
        return $product;
    }

    public function byCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        $stmt = $this->db->prepare('SELECT p.*, MIN(v.price) AS min_price FROM products p
            LEFT JOIN product_variations v ON v.product_id = p.id
            WHERE p.category_id = :category_id AND p.is_active = 1
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function similar(int $categoryId, int $exclude, int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT p.*, MIN(v.price) AS min_price FROM products p
            LEFT JOIN product_variations v ON v.product_id = p.id
            WHERE p.category_id = :category_id AND p.id <> :exclude AND p.is_active = 1
            GROUP BY p.id
            ORDER BY RAND()
            LIMIT :limit');
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':exclude', $exclude, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function search(string $query, int $limit = 30): array
    {
        $stmt = $this->db->prepare('SELECT p.*, MIN(v.price) AS min_price FROM products p
            LEFT JOIN product_variations v ON v.product_id = p.id
            WHERE (p.name LIKE :like OR p.description LIKE :like) AND p.is_active = 1
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT :limit');
        $stmt->bindValue(':like', '%' . $query . '%');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function paginate(array $filters, int $limit, int $offset): array
    {
        $where = [];
        $params = [];
        if (!empty($filters['search'])) {
            $where[] = '(p.name LIKE :search OR p.slug LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $where[] = 'p.is_active = :status';
            $params['status'] = (int)$filters['status'];
        }
        if (!empty($filters['category_id'])) {
            $where[] = 'p.category_id = :category_id';
            $params['category_id'] = (int)$filters['category_id'];
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = 'SELECT p.*, c.name AS category_name, MIN(v.price) AS min_price, SUM(COALESCE(v.stock,0)) AS total_stock
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN product_variations v ON v.product_id = p.id
            ' . $whereSql . '
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(array $filters = []): int
    {
        $where = [];
        $params = [];
        if (!empty($filters['search'])) {
            $where[] = '(name LIKE :search OR slug LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $where[] = 'is_active = :status';
            $params['status'] = (int)$filters['status'];
        }
        if (!empty($filters['category_id'])) {
            $where[] = 'category_id = :category_id';
            $params['category_id'] = (int)$filters['category_id'];
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM products ' . $whereSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO products (category_id, name, slug, description, cover, is_active, created_at)
            VALUES (:category_id, :name, :slug, :description, :cover, :is_active, NOW())');
        $stmt->execute([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'cover' => $data['cover'] ?? null,
            'is_active' => $data['is_active'] ?? 1,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE products SET category_id = :category_id, name = :name, slug = :slug,
            description = :description, cover = :cover, is_active = :is_active WHERE id = :id');
        return $stmt->execute([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'cover' => $data['cover'] ?? null,
            'is_active' => $data['is_active'] ?? 0,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function setActive(int $id, bool $active): bool
    {
        $stmt = $this->db->prepare('UPDATE products SET is_active = :active WHERE id = :id');
        return $stmt->execute(['active' => $active ? 1 : 0, 'id' => $id]);
    }

    public function countActive(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) FROM products WHERE is_active = 1');
        return (int)$stmt->fetchColumn();
    }

    public function topSelling(int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT p.*, MIN(v.price) AS min_price, SUM(oi.qty) AS total_qty
            FROM order_items oi
            INNER JOIN orders o ON o.id = oi.order_id AND o.status = "paid"
            INNER JOIN products p ON p.id = oi.product_id
            LEFT JOIN product_variations v ON v.product_id = p.id
            GROUP BY p.id
            ORDER BY total_qty DESC
            LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
