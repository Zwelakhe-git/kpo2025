<?php

function grantStreamAccess($streamer_name, $access_key, $password){
     require_once __DIR__ . '/config/database.php';
    try{
        $con = mysqli_connect(DB_HOST, DB_USER, 
                             DB_PASS, DB_NAME);
        
        $query = "SELECT 
                    CASE 
                        WHEN vw.name IS NULL THEN 'unregistered'
                        WHEN ak.access_key IS NULL THEN 'wrong_key' 
                        WHEN ak.date_end < CURRENT_TIMESTAMP THEN 'expired'
                        ELSE 'valid'
                    END as status
                  FROM viewers vw
                  LEFT JOIN streamAccesskeys ak ON vw.access_key_id = ak.id
                  WHERE vw.name = ? AND ak.access_key = ?";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $streamer_name, $access_key);
        $res = $stmt->execute();
        if(!QUERYCHECK($res, $stmt)){
            return  ["access" => "denied", "message" => "request error: " . $res];
        }
        $result = $stmt->get_result();
        
        if($row = $result->fetch_assoc()){
            switch($row['status']){
                case 'valid':
                    $stmt = $con->prepare("SELECT us.password_hash as ph FROM viewers vw LEFT JOIN users us ON us.name = vw.name WHERE vw.name = ?");
                    $stmt->bind_param("s", $streamer_name);
                    $res = $stmt->execute();
                    if(QUERYCHECK($res, $stmt)){
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        if(password_verify($password, $row['ph'])){
                            return ["access" => "granted"];
                        } else {
                            return ["access" => "denied", "message" => "incorrect password"];
                        }
                    } else {
                        return ["access" => "denied", "message" => "request error: " . $res];
                    }
                    
                case 'unregistered': return ["access" => "denied", "message" => "unsubscribed account"];
                case 'wrong_key': return ["access" => "denied", "message" => "wrong access key"];
                case 'expired': return ["access" => "denied", "message" => "access key expired"];
                default: return ["access" => "denied", "message" => "invalid password"];
            }
        }
        
        return ["access" => "denied", "message" => "account not found:"];
        
    } catch(Exception $e){
        return ["access" => "denied", "message" => "Database error: " . $e->getMessage()];
    }
}

function registerStreamAccessKey($streamer_name){
    $stream_key_prefix = "konektem_stream_key_";
    $unique_stream_key = uniqid($stream_key_prefix, true) . $streamer_name;
}

if(isset($_POST["login"]) && isset($_POST["accessKey"]) && isset($_POST["password"])){
    $response = grantStreamAccess($_POST["login"], $_POST["accessKey"], $_POST["password"]);
    echo json_encode($response);
} else {
    echo json_encode(["access" => "denied", "message" => "missing parameters"]);
}

function QUERYCHECK($stmt_res, $stmt){
    if(!$stmt_res){
       return false;
    }
    return true;
}
?>