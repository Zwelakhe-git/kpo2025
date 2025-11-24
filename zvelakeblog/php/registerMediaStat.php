<?php
require_once 'config/database.php';
function registerMediaStat($action, $track_id, $user){    
    $username = "if0_39722397";
    $password = "pehBevo9Zxfx";
    $host = "sql101.infinityfree.com";
    $db = $username . "_zvelake";

    try{
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if(!$con){
            return ["response" => "failed", "message" => "failed to connect to db"];
        }
        $activityTblname = $user . '_activities';
        $query = 'SELECT COUNT(*) AS count FROM ' . $activityTblname . ' WHERE activity_name = ? AND item_id = ?';
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $action, $track_id);
        $stmt->execute();
        
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $count = $row['count'];
        if($count > 0){
            $res->close();
            return ['response' => 'failed', 'message' => 'user activity repeat'];
        } 
        
        $query2;
        $query3 = "INSERT INTO ". $activityTblname . " (activity_name, item_id) VALUES (?,?)";
        switch($action){
            case "like":
                $query = "UPDATE Music SET likes = likes + 1 WHERE id = ?";
                $query2 = "SELECT likes FROM Music WHERE id = ?";
                break;
            case "download":
                $query = "UPDATE Music SET downloads = downloads + 1 WHERE id = ?";
                $query2 = "SELECT downloads FROM Music WHERE id = ?";
                break;
            case "plays":
                $query = "UPDATE Music SET plays = plays + 1 WHERE id = ?";
                $query2 = "SELECT plays FROM Music WHERE id = ?";
                break;
            case "dislike":
                $query = "UPDATE Music SET likes = likes - 1 WHERE id = ?";
                $query2 = "SELECT likes FROM Music WHERE id = ?";
                break;
            default:
                $query = "unknown";
                break;
        }

        if($query == "unknown"){
            return ["response" => "failed", "message" => "unknown action"];
        }

        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $track_id);
        $result = $stmt->execute();
        if(!QUERYCHECK($result, $stmt)){
            return [ "response" => "failed", "message" => $stmt->error ];
        }
        $stmt->close();

        $stmt = $con->prepare($query3);
        $stmt->bind_param("ss", $action, $track_id);
        $stmt->execute();
        
        $stmt = $con->prepare($query2);
        $stmt->bind_param("s", $track_id);
        $result = $stmt->execute();
        if(!QUERYCHECK($result, $stmt)){
            return [ "response" => "failed", "message" => $stmt->error ];
        }

        $result = $stmt->get_result();
        if($result->num_rows == 0){
            $stmt->close();
            return ["response" => "failed", "message" => "invalid track id"];
        }
        $row = $result->fetch_array();
        $stmt->close();

        if($action === "like" || $action === "dislike"){
            $action = "like";
        }
        $response = ["response" => [
            "action" => $action,
            "track_id" => $track_id,
            "success" => true,
            "count" => $row[0],
            "user" => $activityTblname
        ]];
        return $response;
    } catch(Exception $e){
        return ["response" => "failed", "message" => $e->getMessage()];
    }
}
header("Content-Type: application/json");
if(isset($_GET["action"]) && isset($_GET["id"]) && isset($_GET['user'])){
    $action = urldecode($_GET["action"]);
    $track_id = urldecode($_GET["id"]);
    $user = urldecode($_GET['user']);
    $response = registerMediaStat($action, $track_id, $user);
    echo json_encode($response);
}
else{
    echo json_encode(["response" => "failed", "message" => "missing parameters"]);
}

function QUERYCHECK($stmt_res, $stmt){
    if(!$stmt_res){
        return false;
    }
    return true;
}

if(isset($con)){
    mysqli_close($con);
}
?>