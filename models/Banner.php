<?php
namespace Models;

class Banner extends BaseModel
{
    public function active(): array
    {
        $stmt = $this->db->query('SELECT * FROM banners WHERE is_active = 1 ORDER BY sort ASC');
        return $stmt->fetchAll();
    }
}
