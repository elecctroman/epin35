<?php
namespace Models;

class Vendor extends BaseModel
{
    public function top(int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT * FROM vendors ORDER BY rating DESC, sales_count DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
