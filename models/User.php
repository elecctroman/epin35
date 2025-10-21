<?php
namespace Models;

use PDO;

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

    public function paginate(array $filters, int $limit, int $offset): array
    {
        $where = [];
        $params = [];
        if (!empty($filters['search'])) {
            $where[] = '(email LIKE :search OR name LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['role'])) {
            $where[] = 'role = :role';
            $params['role'] = $filters['role'];
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare('SELECT * FROM users ' . $whereSql . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
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
            $where[] = '(email LIKE :search OR name LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['role'])) {
            $where[] = 'role = :role';
            $params['role'] = $filters['role'];
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users ' . $whereSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function updateRole(int $id, string $role): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET role = :role WHERE id = :id');
        return $stmt->execute(['role' => $role, 'id' => $id]);
    }

    public function resetTwoFactor(int $id): bool
    {
        $stmt = $this->db->prepare('UPDATE users SET twofa_secret = NULL WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
