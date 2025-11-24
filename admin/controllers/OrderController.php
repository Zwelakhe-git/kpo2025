<?php
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/config/config.php';
class OrderController {
    private $model;
    
    public function __construct() {
        $this->model = new OrderModel();
    }
    
    public function index() {
        $orders = $this->model->getAllOrders();
        require_once __DIR__ . '/../views/orders/list.php';
    }
    
    public function createOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Создаем клиента
            $clientData = [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'phone' => $input['phone'] ?? null
            ];
            
            $clientId = $this->model->createClient($clientData);
            
            if ($clientId) {
                // Создаем заказ
                $orderData = [
                    'client_id' => $clientId,
                    'event_id' => $input['event_id'],
                    'ticket_count' => $input['ticket_count'],
                    'total_amount' => $input['total_amount'],
                    'transaction_id' => uniqid('ORDER_')
                ];
                
                $orderId = $this->model->createOrder($orderData);
                
                if ($orderId) {
                    return [
                        'success' => true,
                        'order_id' => $orderId,
                        'message' => 'Order created successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Failed to create order'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to create client'
                ];
            }
        }
    }
}
?>