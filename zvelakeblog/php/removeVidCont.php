<?php
if(isset($_POST["coverImage"]) && isset($_POST["location"])){
    error_reporting(E_ALL);
    $username = "if0_39722397";
    $password = "pehBevo9Zxfx";
    $host = "sql101.infinityfree.com";
    $db = $username . "_zvelake";

    $connection = mysqli_connect($hostname, $username, $password);
    if(!$connection){
        die("Failed to connect to server");
    }
    if(!mysqli_select_db($connection, $db)){
        die("Failed to select database");
    }
    $coverImg = $_POST["coverImage"];
    $src = $_POST["location"];
    $tableName = "VideoContent";

    $query = "DELETE FROM $tableName WHERE coverImage = ? OR videoLocation = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $coverImg, $src);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "failed", "error" => mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = ["status" => "success", "error" => mysqli_connect_error($connection)];
        echo json_encode($response);
    }
    
    mysqli_close($connection);
}else{
    echo json_encode(["status" => "failed", "error" => "Missing Parameters"]);
}
?>