<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class LiveStreamModel extends Database {
    
    public function getAllStreams() {
        $stmt = $this->pdo->query("SELECT * FROM livestream ORDER BY stream_date DESC");
        return $stmt->fetchAll();
    }
    
    public function getStreamById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM livestream WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createStream($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO livestream (stream_date, stream_title, stream_key) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['stream_date'],
            $data['stream_title'],
            $data['stream_key']
        ]);
    }
    
    public function updateStream($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE livestream 
            SET stream_date = ?, stream_title = ?, stream_key = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['stream_date'],
            $data['stream_title'],
            $data['stream_key'],
            $id
        ]);
    }
    
    public function deleteStream($id) {
        $stmt = $this->pdo->prepare("DELETE FROM livestream WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function generateStreamKey() {
        return bin2hex(random_bytes(10));
    }
}
?>