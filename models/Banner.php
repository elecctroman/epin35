<?php
namespace Models;

class Banner extends BaseModel
{
    public function active(): array
    {
        $stmt = $this->db->query('SELECT * FROM banners WHERE is_active = 1 ORDER BY sort ASC');
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM banners ORDER BY sort ASC, id DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM banners WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $banner = $stmt->fetch();
        return $banner ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO banners (title, image, url, sort, is_active) VALUES (:title, :image, :url, :sort, :is_active)');
        $stmt->execute([
            'title' => $data['title'],
            'image' => $data['image'],
            'url' => $data['url'],
            'sort' => $data['sort'] ?? 0,
            'is_active' => $data['is_active'] ?? 1,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE banners SET title = :title, image = :image, url = :url, sort = :sort, is_active = :is_active WHERE id = :id');
        return $stmt->execute([
            'title' => $data['title'],
            'image' => $data['image'],
            'url' => $data['url'],
            'sort' => $data['sort'] ?? 0,
            'is_active' => $data['is_active'] ?? 0,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM banners WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
