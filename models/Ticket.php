<?php
namespace Models;

use PDO;

class Ticket extends BaseModel
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO tickets (user_id, order_id, subject, status, created_at) VALUES (:user_id, :order_id, :subject, :status, NOW())');
        $stmt->execute([
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'],
            'subject' => $data['subject'],
            'status' => $data['status'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function addMessage(int $ticketId, ?int $userId, string $body): void
    {
        $stmt = $this->db->prepare('INSERT INTO ticket_messages (ticket_id, user_id, body, created_at) VALUES (:ticket_id, :user_id, :body, NOW())');
        $stmt->execute([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'body' => $body
        ]);
    }

    public function forUser(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM tickets WHERE user_id = :user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function paginate(array $filters, int $limit, int $offset): array
    {
        $where = [];
        $params = [];
        if (!empty($filters['status'])) {
            $where[] = 't.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(t.subject LIKE :search OR u.email LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = 'SELECT t.*, u.email FROM tickets t LEFT JOIN users u ON u.id = t.user_id ' . $whereSql . ' ORDER BY t.created_at DESC LIMIT :limit OFFSET :offset';
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
        if (!empty($filters['status'])) {
            $where[] = 'status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = 'subject LIKE :search';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM tickets ' . $whereSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT t.*, u.email FROM tickets t LEFT JOIN users u ON u.id = t.user_id WHERE t.id = :id');
        $stmt->execute(['id' => $id]);
        $ticket = $stmt->fetch();
        if (!$ticket) {
            return null;
        }
        $messagesStmt = $this->db->prepare('SELECT tm.*, u.email FROM ticket_messages tm LEFT JOIN users u ON u.id = tm.user_id WHERE tm.ticket_id = :ticket_id ORDER BY tm.created_at ASC');
        $messagesStmt->execute(['ticket_id' => $id]);
        $ticket['messages'] = $messagesStmt->fetchAll();
        return $ticket;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE tickets SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
