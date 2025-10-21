<?php
namespace Models;

use PDO;

class Order extends BaseModel
{
    public function create(array $data, array $items): array
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO orders (user_id, status, total, payment_method, payment_ref, created_at) VALUES (:user_id, :status, :total, :payment_method, :payment_ref, NOW())');
            $stmt->execute([
                'user_id' => $data['user_id'],
                'status' => $data['status'],
                'total' => $data['total'],
                'payment_method' => $data['payment_method'],
                'payment_ref' => $data['payment_ref']
            ]);
            $orderId = (int)$this->db->lastInsertId();

            $itemStmt = $this->db->prepare('INSERT INTO order_items (order_id, product_id, variation_id, qty, unit_price, delivered_payload) VALUES (:order_id, :product_id, :variation_id, :qty, :unit_price, :delivered_payload)');
            foreach ($items as $item) {
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'variation_id' => $item['variation_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'delivered_payload' => $item['delivered_payload'] ?? null,
                ]);
            }
            $this->db->commit();
            return ['id' => $orderId];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function recent(int $limit = 10): array
    {
        $stmt = $this->db->prepare('SELECT o.*, u.email FROM orders o LEFT JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function paginate(array $filters, int $limit, int $offset): array
    {
        $where = [];
        $params = [];
        if (!empty($filters['status'])) {
            $where[] = 'o.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(u.email LIKE :search OR o.payment_ref LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = 'SELECT o.*, u.email FROM orders o LEFT JOIN users u ON u.id = o.user_id ' . $whereSql . ' ORDER BY o.created_at DESC LIMIT :limit OFFSET :offset';
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
            $where[] = '(payment_ref LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM orders ' . $whereSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT o.*, u.email, u.name FROM orders o LEFT JOIN users u ON u.id = o.user_id WHERE o.id = :id');
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch();
        if (!$order) {
            return null;
        }
        $itemsStmt = $this->db->prepare('SELECT oi.*, p.name, pv.title FROM order_items oi LEFT JOIN products p ON p.id = oi.product_id LEFT JOIN product_variations pv ON pv.id = oi.variation_id WHERE oi.order_id = :order_id');
        $itemsStmt->execute(['order_id' => $id]);
        $order['items'] = $itemsStmt->fetchAll();
        return $order;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE orders SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function metrics(): array
    {
        $todayStmt = $this->db->query("SELECT IFNULL(SUM(total),0) FROM orders WHERE status = 'paid' AND DATE(created_at) = CURDATE()");
        $todaySales = (float)$todayStmt->fetchColumn();

        $activeProductsStmt = $this->db->query('SELECT COUNT(*) FROM products WHERE is_active = 1');
        $activeProducts = (int)$activeProductsStmt->fetchColumn();

        $pendingStmt = $this->db->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
        $pending = (int)$pendingStmt->fetchColumn();

        $monthlyStmt = $this->db->query("SELECT IFNULL(SUM(total),0) FROM orders WHERE status = 'paid' AND YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())");
        $monthlySales = (float)$monthlyStmt->fetchColumn();

        $avgStmt = $this->db->query("SELECT IFNULL(AVG(total),0) FROM orders WHERE status = 'paid'");
        $avg = (float)$avgStmt->fetchColumn();

        return [
            'today_sales' => $todaySales,
            'active_products' => $activeProducts,
            'pending_orders' => $pending,
            'month_sales' => $monthlySales,
            'average_ticket' => $avg,
        ];
    }

    public function revenueTimeline(int $days = 7): array
    {
        $stmt = $this->db->prepare("SELECT DATE(created_at) AS day, SUM(total) AS total FROM orders WHERE status = 'paid' AND created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY) GROUP BY DATE(created_at) ORDER BY day ASC");
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $timeline = [];
        foreach ($rows as $row) {
            $timeline[$row['day']] = (float)$row['total'];
        }
        return $timeline;
    }

    public function statusBreakdown(): array
    {
        $stmt = $this->db->query('SELECT status, COUNT(*) AS total FROM orders GROUP BY status');
        $rows = $stmt->fetchAll();
        $breakdown = [];
        foreach ($rows as $row) {
            $breakdown[$row['status']] = (int)$row['total'];
        }
        return $breakdown;
    }

    public function forUser(int $userId, int $limit = 10): array
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
