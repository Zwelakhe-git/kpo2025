<!DOCTYPE html>
<html>
    <head>
        <style>
            body{
                display : flex;
                flex-direction : column;
                align-items : center;
                justify-content : center;
            }
        </style>
    </head>
    <body>
<?php
if(isset($_FILES["coverImage"]) && isset($_FILES["videoFile"]) && isset($_POST["description"])){
    // echo "<span>cover Image locaion : " . basename($_FILES["coverImage"]["name"]) .
    // ", type : " . $_FILES["coverImage"]["type"] .
    // ", size : " . $_FILES["coverImage"]["size"] .
    // "</span><br/>" .
    // "<span>video location : " . basename($_FILES["videoFile"]["name"]) .
    // ", type : " . $_FILES["videoFile"]["type"] .
    // ", size : " . $_FILES["videoFile"]["size"] .
    // "</span><br/>" .
    // "<span>Video description : " . $_POST["description"] . "</span><br/>";

    $allowedImageTypes = ["image/jpeg", "image/png", "image/webp", "image/gif"];
    $allowedVideoTypes = ["video/mp4", "video/avi", "video/mpeg"];
    $maxFileSize = 10 * 1024 * 1024;

    $imgDir = "../media/images/";
    $vidDir = "../media/videos/";

    if(!file_exists($imgDir)){
        mkdir($imgDir, 0755, true);
    }

    if(!file_exists($vidDir)){
        mkdir($vidDir, 0755, true);
    }

    $cleanImageName = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES["coverImage"]["name"]));
    $cleanVideoName = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES["videoFile"]["name"]));

    $Imgdest = $imgDir . uniqid("img_", true) . "_" . $cleanImageName;
    $vidDest = $vidDir . uniqid("vid_", true) ."_" . $cleanVideoName;
    //echo "<h3>" . $Imgdest . "</h3><br/><h3>" . $vidDest . "</h3><br/><h3>" . $maxFileSize . "</h3><br/>";


    if(!in_array($_FILES["coverImage"]["type"], $allowedImageTypes) || $_FILES["coverImage"]["size"] > $maxFileSize){
        die("изображение имеет недопустимый тип или больше допустимого размера");
    }
    
    if(!in_array($_FILES["videoFile"]["type"], $allowedVideoTypes) || $_FILES["videoFile"]["size"] > $maxFileSize){
        die("видео имеет недопустимый тип или больше допустимого размера");
    }
    if($_FILES["videoFile"]["error"] !== UPLOAD_ERR_OK){
        die("Ошибка загрузки видео: " . $_FILES["videoFile"]["error"]);
    }
    
    if($_FILES["coverImage"]["error"] !== UPLOAD_ERR_OK){
        die("Ошибка загрузки изображения: " . $_FILES["coverImage"]["error"]);
    }

    if(is_uploaded_file($_FILES["coverImage"]["tmp_name"]) && is_uploaded_file($_FILES["videoFile"]["tmp_name"])){
        if(move_uploaded_file($_FILES["coverImage"]["tmp_name"], $Imgdest) && move_uploaded_file($_FILES["videoFile"]["tmp_name"], $vidDest)){
            echo "<h3>файлы успешно сохранены</h3><br/>";
        }
        else{
            die("Ошибка сохранения файлов");
        }
    }else{
        die("Файлы не были загружены корректно");
    }
    $username = "if0_39722397";
    $password = "pehBevo9Zxfx";
    $host = "sql101.infinityfree.com";
    $db = $username . "_zvelake";
    $connection = mysqli_connect($host, $username, $password);
    if(!$connection){
        die("не удалось подключиться к серверу");
    }
    if(!mysqli_select_db($connection, $db)){
        die("не удалось выбирать базу данных");
    }
    $Imgdest = "/media/" . $Imgdest;
    $vidDest = "/media/" . $vidDest; 
    $query = "INSERT INTO VideoContent (coverImage, videoLocation, description)
    VALUES ('$Imgdest', '$vidDest', '" . $_POST["description"] . "')";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("не удалось сохранить данные в таблице");
    }
    echo "<h2>Данные успешно записаны в таблицу</h2><br />";

}
else{
    die("problems when seding the files");
}
?>
<script>
    setTimeout(() => {
        history.back();
    },5000)
</script>
</body>
</html>