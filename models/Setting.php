<?php
namespace Models;

class Setting extends BaseModel
{
    public function get(string $key, $default = null)
    {
        $stmt = $this->db->prepare('SELECT value FROM settings WHERE `key` = :key');
        $stmt->execute(['key' => $key]);
        $result = $stmt->fetchColumn();
        if ($result === false) {
            return $default;
        }
        return json_decode($result, true) ?? $default;
    }
}
