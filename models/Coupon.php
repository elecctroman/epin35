<?php
namespace Models;

use PDO;

class Coupon extends BaseModel
{
    public function findActive(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM coupons WHERE code = :code AND (usage_limit IS NULL OR usage_limit > 0) AND starts_at <= NOW() AND ends_at >= NOW()');
        $stmt->execute(['code' => $code]);
        $coupon = $stmt->fetch();
        return $coupon ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM coupons ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM coupons WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $coupon = $stmt->fetch();
        return $coupon ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO coupons (code, type, value, min_total, starts_at, ends_at, usage_limit) VALUES (:code, :type, :value, :min_total, :starts_at, :ends_at, :usage_limit)');
        $stmt->execute([
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'min_total' => $data['min_total'] ?? null,
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'usage_limit' => $data['usage_limit'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE coupons SET code = :code, type = :type, value = :value, min_total = :min_total, starts_at = :starts_at, ends_at = :ends_at, usage_limit = :usage_limit WHERE id = :id');
        return $stmt->execute([
            'code' => $data['code'],
            'type' => $data['type'],
            'value' => $data['value'],
            'min_total' => $data['min_total'] ?? null,
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'usage_limit' => $data['usage_limit'] ?? null,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM coupons WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
