<?php
require_once 'Database.php';

class AdminModel extends Database {
    public function grantLogin($data){
        try{
            $stmt = $this->pdo->prepare("SELECT
            CASE WHEN name IS NULL THEN 'unregistered' ELSE 'registered' END AS status,
            id,name,
            password_hash
            FROM users WHERE name = ? LIMIT 1");

            $stmt->execute([
                $data['login']
            ]);
            $result = $stmt->fetch();

            if($result == false){
                return ["access" => "denied", "message" => "invalid login or password"];
            }
            if($result['status'] === 'unregistered') return ['access' => 'denied', 'message' => 'unregistered'];

            if(password_verify($data['password'], $result['password_hash'])){
                return ['access' => 'granted', 'name' => $result['name']];
            }

            return ['access' => 'denied', 'message' => 'wrong_password'];
        } catch (PDOException $e){
            return ["access" => "denied", "message" => "system-error: " . $e->getMessage()];
        }
    }

    public function registerUser($data){
        try{
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ? OR email = ?");
            $stmt->execute([$data['name'], $data['email']]);
            $user_count = $stmt->fetchColumn();
            
            if ($user_count > 0) {                
                // Проверяем что именно существует
                $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
                $stmt->execute([$data['name']]);
                if ($stmt->fetchColumn() > 0) {
                    return ['response' => 'fail', "message" => "Username already exists"];
                } else {
                    return ['response' => 'fail', "message" => "Email already exists"];
                }
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (name, password_hash, email)
            VALUES (?, ?, ?)");
            $result = $stmt->execute([
                $data['name'],
                $data['password_hash'],
                $data['email']
            ]);
            $tname = $data['name'] . '_activities';
            $sql = "CREATE TABLE " . $tname .
                " ( id SERIAL PRIMARY KEY,
                activity_name VARCHAR(50) NOT NULL,
                item_name VARCHAR(50) NOT NULL DEFAULT 'Music',
                item_id BIGINT(20) UNSIGNED NOT NULL,
                activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
                ENGINE INNODB CHARSET utf8mb4 COLLATE utf8mb4_general_ci
            ";
            $this->pdo->query($sql);

            if($result){
                return ['response' => 'success', 'message' => 'you can now log in'];
            }
            return ['response' => 'fail', 'message' => 'server error'];

        } catch(PDOException $e){
            error_log($e->getMessage());
            return ['response' => 'fail', 'message' => 'Server error'];
        }
    }
    public function getUserActivity($username){
        try{
            $activityTblname = $username . '_activities';
            $sql = "SELECT * FROM " . $activityTblname;
            $result = $this->pdo->query($sql);
            $rows = $result->fetchAll();
            if(count($rows) > 0){
                return $rows;
            } else {
                return ["error" => 1, "message" => "no activities"];
            }
        } catch(PDOException $e){
            return ["error" => 2, "message" => "server error"];
        }
    }
    
    public function recordMediaActivity($activity, $item_id, $user){
        try{
            $activityTblname = $user . '_activities';
            if($activity == 'like'){
                $sql = 'SELECT COUNT(*) FROM ' . $activityTblname . ' WHERE activity_name = ? AND item_id = ?';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$activity, $item_id]);
                $count = $stmt->fetchColumn();

                if($count > 0){
                    return ['response' => 'fail', 'message' => 'user activity repeat'];
                }
            }

            $this->pdo->beginTransaction();
            if($activity != 'plays'){
                $sql = "INSERT INTO ". $activityTblname . " (activity_name, item_id) VALUES (?,?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$activity, $item_id]);
            }
            
            $column = '';
            switch($activity){
                case "like":
                    $column = 'likes';
                    break;
                case "download":
                    $column = 'downloads';
                    break;
                case "plays":
                    $column = 'plays';
                    break;
                case "share":
                    $column = 'share';
                    break;
                default:
                    throw new Exception("Unknown activity: " . $activity);
            }

            $sql = "UPDATE Music SET $column = $column + 1 WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$item_id]);

            $sql = "SELECT $column FROM Music WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$item_id]);

            $count = $stmt->fetchColumn();

            $this->pdo->commit();

            $response = ["response" => [
                "action" => $activity,
                "track_id" => $item_id,
                "success" => true,
                "count" => $count,
            ]];
            return $response;

        } catch(PDOException $e){
            if($this->pdo->inTransaction()){
                $this->pdo->rollback();
            }

            error_log($e->getMessage());
            return ['response' => 'fail', 'message' => 'server error:' . $e->getMessage()];
        } catch(Exception $e){
            if($this->pdo->inTransaction()){
                $this->pdo->rollback();
            }

            error_log($e->getMessage());
            return ['response' => 'fail', 'message' => $e->getMessage()];
        }
    }

}

?>