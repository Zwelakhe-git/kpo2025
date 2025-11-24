<?php
$username = "if0_39722397";
$password = "pehBevo9Zxfx";
$host = "sql101.infinityfree.com";
$db = $username . "_zvelake";

$connection = mysqli_connect($host, $username, $password);
if(!$connection){
    die("Failed to connect to database" . mysqli_connect_error());
}

if(!mysqli_select_db($connection, $db)){
    die("Failed to selected database" . mysqli_error($connection));
}

echo "<h1>Connection was sucessful</h1><br />";

$table_name = "Videos v, Images im";
echo "<h3>showing table: $table_name</h3><br/>";
$query = "SELECT im.location AS imgUrl, v.location AS videoLocation,v.vidTitle AS description, im.mime_type AS imageType, v.mime_type AS videoType FROM Videos v, Images im WHERE v.vidImg = im.id";
$query2 = "SELECT coverImage AS imgUrl, videoLocation, description, imageType, videoType FROM VideoContent";

$results = [
    "Videos" => mysqli_query($connection, $query),
    "videoContent" => mysqli_query($connection, $query2)
];
    
foreach($results as $tName => $res){
    checkQuery($res);
    echo "<h3>$tName</h3>";
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            echo json_encode($row);
        }
    }
}

function checkQuery($res){
    if(!$res){
        print_r("query failed to execute\n");
        die();
    }
    return "OK";
}

mysqli_close($connection);

?>