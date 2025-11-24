<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class VideoModel extends Database {
    
    public function getAllVideos() {
        $stmt = $this->pdo->query("
            SELECT v.*, i.location as image_location 
            FROM Videos v 
            LEFT JOIN Images i ON v.vidImg = i.id 
            ORDER BY v.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getVideoById($id) {
        $stmt = $this->pdo->prepare("
            SELECT v.*, i.location as image_location 
            FROM Videos v 
            LEFT JOIN Images i ON v.vidImg = i.id 
            WHERE v.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createVideo($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Videos (vidImg, vidTitle, location, mime_type) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['vidImg'],
            $data['vidTitle'],
            $data['location'],
            $data['mime_type']
        ]);
    }
    
    public function updateVideo($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE Videos 
            SET vidImg = ?, vidTitle = ?, location = ?, mime_type = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['vidImg'],
            $data['vidTitle'],
            $data['location'],
            $data['mime_type'],
            $id
        ]);
    }
    
    public function deleteVideo($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Videos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>