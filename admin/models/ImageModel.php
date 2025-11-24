<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class ImageModel extends Database {
    
    public function createImage($location, $mime_type) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Images (location, mime_type) 
            VALUES (?, ?)
        ");
        $stmt->execute([$location, $mime_type]);
        return $this->pdo->lastInsertId();
    }
    
    public function getImageById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Images WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function deleteImage($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Images WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>