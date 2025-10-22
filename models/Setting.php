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

    public function set(string $key, $value): bool
    {
        $stmt = $this->db->prepare('INSERT INTO settings (`key`, value) VALUES (:key, :value)
            ON DUPLICATE KEY UPDATE value = VALUES(value)');
        return $stmt->execute([
            'key' => $key,
            'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT `key`, value FROM settings');
        $settings = [];
        foreach ($stmt->fetchAll() as $row) {
            $settings[$row['key']] = json_decode($row['value'], true);
        }
        return $settings;
    }
}
