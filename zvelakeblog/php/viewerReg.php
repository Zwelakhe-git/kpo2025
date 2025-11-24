<?php
require_once 'config/database.php';
function registerUser($username, $email, $password, $access_key) {
    
    $url = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $pdo = new PDO($url, DB_USER, DB_PASS);
    
    try {
       
        $pdo->beginTransaction();
        
        // Проверяем существование пользователя
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
        $stmt->execute([$username]);
        $user_count = $stmt->fetchColumn();
        
        if ($user_count > 0) {
            $pdo->rollBack();
            
            // Проверяем что именно существует
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn() > 0) {
                return ["success" => false, "message" => "Username already exists"];
            } else {
                return ["success" => false, "message" => "Email already exists"];
            }
        }
        
        // Вставляем пользователя
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password_hash]);
        $userid = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("INSERT INTO streamAccesskeys (access_key) VALUES (?)");
        $stmt->execute([$access_key]);
        $accessKeyId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO viewers (name, access_key_id) VALUES (?, ?)");
        $stmt->execute([$username, $accessKeyId]);
        
        if($pdo->inTransaction()){
            $pdo->commit();
        }
        $stmt = $pdo->prepare("SELECT date_end FROM streamAccesskeys WHERE id = ?");
        $stmt->execute([$accessKeyId]);
        return ["success" => true, "expiration_date" => $stmt->fetchColumn()];
        
    } catch (PDOException $e) {
        if($pdo->inTransaction()){
            $pdo->rollBack();
        }
        return ["success" => false, "message" => "Registration failed: " . $e];
    }
}

// для получения как json
// $input = json_decode(file_get_contents('php://input'), true)
if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["accessKey"])){
    $response = registerUser($_POST["login"], $_POST["email"], $_POST["password"], $_POST["accessKey"]);
    echo json_encode($response);
}
else{
    echo json_encode(["success" => false, "message" => "missing fields"]);
}

function escapeTableName($tname){
    return "`" . str_replace("`", "``", $tname) . "`";
}
?>