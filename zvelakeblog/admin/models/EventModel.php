<?php
define('ROOT_PATH', __DIR__);
require_once 'Database.php';

class EventModel extends Database {
    
    public function getAllEvents() {
        $stmt = $this->pdo->query("
            SELECT e.*, i.location as image_location 
            FROM Events e 
            LEFT JOIN Images i ON e.eventImage = i.id 
            ORDER BY e.eventDate DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getEventById($id) {
        $stmt = $this->pdo->prepare("
            SELECT e.*, i.location as image_location 
            FROM Events e 
            LEFT JOIN Images i ON e.eventImage = i.id 
            WHERE e.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function createEvent($data) {
        try {
            $this->pdo->beginTransaction();

            // First insert into Images
            $stmt1 = $this->pdo->prepare("INSERT INTO Images (location) VALUES (?)");
            $stmt1->execute([$data['eventImage']]);
            $imageId = $this->pdo->lastInsertId();

            // Then insert into Events using the image ID
            $stmt2 = $this->pdo->prepare("
                INSERT INTO Events (title, eventDate, location, price, eventImage) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt2->execute([
                $data['title'],
                $data['eventDate'],
                $data['location'],
                $data['price'],
                $imageId
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    public function updateEvent($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE Events 
            SET title = ?, eventDate = ?, location = ?, price = ?, eventImage = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['eventDate'],
            $data['location'],
            $data['price'],
            $data['eventImage'],
            $id
        ]);
    }
    
    public function deleteEvent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Events WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>