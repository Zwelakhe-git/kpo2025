<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class MusicModel extends Database {
    
    public function getAllMusic() {
        $stmt = $this->pdo->query("
            SELECT m.*, a.name as artist_name, i.location as image_location 
            FROM Music m 
            LEFT JOIN Artists a ON m.artist_id = a.id 
            LEFT JOIN Images i ON m.track_img_id = i.id
            ORDER BY m.id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function createMusic($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Music (track_name, artist_id, track_img_id, location, mime_type, likes, downloads, plays) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['track_name'],
            $data['artist_id'],
            $data['track_img_id'],
            $data['location'],
            $data['mime_type'],
            $data['likes'] ?? 0,
            $data['downloads'] ?? 0,
            $data['plays'] ?? 0
        ]);
    }
    
    public function getAllArtists() {
        $stmt = $this->pdo->query("SELECT * FROM Artists ORDER BY name");
        return $stmt->fetchAll();
    }
    
    public function createArtist($name) {
        $stmt = $this->pdo->prepare("INSERT INTO Artists (name) VALUES (?)");
        $stmt->execute([$name]);
        return $this->pdo->lastInsertId();
    }

    public function getMusicById($id){
        $stmt = $this->pdo->prepare("SELECT m.*, a.name, im.location as track_location
        FROM Music m
        LEFT JOIN Artists a ON a.id = m.artist_id
        LEFT JOIN Images im ON im.id = m.track_img_id
        WHERE m.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function deleteMusic($id){
        $stmt = $this->pdo->prepare("
            DELETE FROM Music WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
    
    public function updateMusic($id,$data){
        $stmt = $this->pdo->prepare("UPDATE Music SET track_name=?, artist_id=?, track_img_id=?,
        location=?, mime_type=?, likes=?, downloads=?, plays=? WHERE id = ?");
        return $stmt->execute([
            $data['track_name'],
            $data['artist_id'],
            $data['track_img_id'],
            $data['location'],
            $data['mime_type'],
            $data['likes'],
            $data['downloads'],
            $data['plays'],
            $id
        ]);
    }
}
?>