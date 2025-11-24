<?php
if(isset($_POST["name"]) && isset($_POST["description"])){
    $username = "if0_39722397";
    $password = "pehBevo9Zxfx";
    $host = "sql101.infinityfree.com";
    $db = $username . "_zvelake";

    $connection = mysqli_connect($host, $username, $password);
    if(!$connection){
        die("" . mysqli_connect_error($connection));
    }

    if(!mysqli_select_db($connection, $db)){
        die("не удалось выбирать базу данных");
    }

    $query = "DELETE FROM Services WHERE name = '" . $_POST["name"] . "' OR description = '" . $_POST["description"] . "'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("не удалось выполнять запрос удаления данных из базы данных");
    }
    echo json_encode("status : success");
    mysqli_close($connection);
}
echo "<h2>MISSING PARAMETERS</h2>";
?>