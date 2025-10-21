<?php
namespace Models;

class Coupon extends BaseModel
{
    public function findActive(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM coupons WHERE code = :code AND (usage_limit IS NULL OR usage_limit > 0) AND starts_at <= NOW() AND ends_at >= NOW()');
        $stmt->execute(['code' => $code]);
        $coupon = $stmt->fetch();
        return $coupon ?: null;
    }
}
