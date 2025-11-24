
<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';
class OrderModel extends Database {
    
    public function createClient($clientData) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO clients (first_name, last_name, email, phone) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $clientData['first_name'],
                $clientData['last_name'],
                $clientData['email'],
                $clientData['phone']
            ]);
            return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
            // Если email уже существует, возвращаем существующий ID
            if ($e->getCode() == 23000) {
                $stmt = $this->pdo->prepare("SELECT id FROM clients WHERE email = ?");
                $stmt->execute([$clientData['email']]);
                $client = $stmt->fetch();
                return $client ? $client['id'] : false;
            }
            return false;
        }
    }
    
    public function createOrder($orderData) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO orders (client_id, event_id, ticket_count, total_amount, transaction_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $orderData['client_id'],
                $orderData['event_id'],
                $orderData['ticket_count'],
                $orderData['total_amount'],
                $orderData['transaction_id']
            ]);
            return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
            error_log("Order creation error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getEventById($eventId) {
        $stmt = $this->pdo->prepare("
            SELECT e.*, i.location as image_location 
            FROM Events e 
            LEFT JOIN Images i ON e.eventImage = i.id 
            WHERE e.id = ?
        ");
        $stmt->execute([$eventId]);
        return $stmt->fetch();
    }
    
    public function getAllOrders() {
        $stmt = $this->pdo->query("
            SELECT o.*, e.title as event_title, c.first_name, c.last_name, c.email 
            FROM orders o 
            JOIN Events e ON o.event_id = e.id 
            JOIN clients c ON o.client_id = c.id 
            ORDER BY o.order_date DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function updateOrderStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
    
    public function updatePaymentStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("
            UPDATE orders SET payment_status = ?, payment_date = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$status, $orderId]);
    }
}
?>