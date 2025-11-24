<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class NewsModel extends Database {
    
    public function getAllNews() {
        $stmt = $this->pdo->query("
            SELECT n.*, i.location as image_location 
            FROM News n 
            LEFT JOIN Images i ON n.newsImg = i.id 
            ORDER BY n.newsDate DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getNewsById($id) {
        $stmt = $this->pdo->prepare("
            SELECT n.*, i.location as image_location 
            FROM News n 
            LEFT JOIN Images i ON n.newsImg = i.id 
            WHERE n.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createNews($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO News (newsImg, newsCategory, newsTitle, newsHeadline, fullContent, newsDate) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['newsImg'],
            $data['newsCategory'],
            $data['newsTitle'],
            $data['newsHeadline'],
            $data['fullContent'],
            $data['newsDate']
        ]);
    }
    
    public function updateNews($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE News 
            SET newsImg = ?, newsCategory = ?, newsTitle = ?, newsHeadline = ?, fullContent = ?, newsDate = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['newsImg'],
            $data['newsCategory'],
            $data['newsTitle'],
            '' . $data['newsHeadline'],
            $data['fullContent'],
            $data['newsDate'],
            $id
        ]);
    }
    
    public function deleteNews($id) {
        $stmt = $this->pdo->prepare("DELETE FROM News WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>