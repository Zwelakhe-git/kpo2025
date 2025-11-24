<?php
require_once 'Database.php';

class PartnersModel extends Database {

    public function getAllPartners(){
        try{
            $stmt = $this->pdo->query("SELECT p.*, im.location AS image_location FROM partners p LEFT JOIN Images im ON im.id = p.image_id");
            return $stmt->fetchAll();
        } catch(PDOException $e){
            return [];
        }
    }
    
    public function createPartner($data){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO partners (name, image_id) VALUES (?,?)");
            return $stmt->execute([
                $data['partner_name'],
                $data['image_id']
            ]);
        } catch(PDOException $e){
            return false;
        }
    }

    public function deletePartner($id){
        try{

            $stmt = $this->pdo->prepare("DELETE FROM partners WHERE id = ?");
            return $stmt->execute([$id]);

        } catch(PDOException $e){
            return false;
        }
    }

    public function getPartnerById($id){
        try{
            $stmt = $this->pdo->prepare("SELECT p.*, im.location AS image_location FROM partners p LEFT JOIN Images im ON im.id = p.image_id WHERE p.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch(PDOException $e){
            return [];
        }
    }

    public function editPartner($id, $data){
        try{
            $stmt = $this->pdo->prepare("UPDATE partners SET name = ?, image_id = ? WHERE id = ?");
            return $stmt->execute([
                $data['name'],
                $data['image_id'],
                $id
            ]);
        } catch(PDOException $e){
            return false;
        }
    }
}
?>