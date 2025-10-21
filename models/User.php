<?php
namespace Models;

class User extends BaseModel
{
    protected string $table = 'users';

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO users (email, password_hash, name, phone, role, twofa_secret) VALUES (:email, :password_hash, :name, :phone, :role, :twofa_secret)');
        $stmt->execute([
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'role' => $data['role'] ?? 'user',
            'twofa_secret' => $data['twofa_secret'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }
}
