<?php
$username = "if0_39722397";
$password = "pehBevo9Zxfx";
$host = "sql101.infinityfree.com";
$db = $username . "_zvelake";
error_reporting(E_ALL);

$connection = mysqli_connect($host, $username, $password);
if(!$connection){
    die("Failed to connect to database" . mysqli_connect_error());
}

if(!mysqli_select_db($connection, $db)){
    die("Failed to selected database" . mysqli_error($connection));
}

$resourcesToFetch = [
    [
        "name" => "musicContent",
        "sqlquery" => "SELECT coverImage,videoLocation,description,imageType,videoType FROM VideoContent",
        "result" => []
    ],
    [
        "name" => "services",
        "sqlquery" => "SELECT name,description FROM Services",// 
        "result" => []
    ],
    [
        "name" => "news",
        "sqlquery" => "",// SELECT coverImage,imageType,newsDate,newsHeadline,newsContent FROM NewsContent
        "result" => []
    ],
    [
        "name" => "charts",
        "sqlquery" => "",
        "result" => []
    ],
    [
        "name" => "events",
        "sqlquery" => "SELECT title,eventDate,location,price,eventImage,eventurl FROM Events",
        "result" => []
    ]
];

header("Content-Type: text/json");

$finalReponse = [];

foreach ($resourcesToFetch as $_ => $resource){
    if($resource["sqlquery"] !== ""){
        
        try{
            $queryResult = mysqli_query($connection, $resource["sqlquery"]);
            if(!$queryResult){
                
                continue;
                // die("Failed to execute request : " . mysqli_error($connection));
            }
            $i = 0;
            if(mysqli_num_rows($queryResult) > 0){
                while($row = mysqli_fetch_assoc($queryResult)){
                    $resource["result"][$i++] = $row;
                }
            }
            $finalReponse[$resource["name"]] = $resource["result"];
        }catch(mysqli_error){
            echo "request failed" . mysqli_error($connection);
        }
    }
}

echo json_encode($finalReponse);

?>