<?php
namespace Models;

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
}
