<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class ServiceModel extends Database {
    
    public function getAllServices() {
        $stmt = $this->pdo->query("
            SELECT s.*, i.location as image_location 
            FROM Services s 
            LEFT JOIN Images i ON s.serviceImg = i.id 
            ORDER BY s.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getServiceById($id) {
        $stmt = $this->pdo->prepare("
            SELECT s.*, i.location as image_location 
            FROM Services s 
            LEFT JOIN Images i ON s.serviceImg = i.id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createService($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Services (name, description, serviceImg) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['serviceImg']
        ]);
    }
    
    public function updateService($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE Services 
            SET name = ?, description = ?, serviceImg = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['serviceImg'],
            $id
        ]);
    }
    
    public function deleteService($id) {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>