<?php
if(isset($_FILES["coverImage"]) && isset($_POST["newsContent"]) &&
isset($_POST["newsDate"]) && isset($_POST["newsHeadline"])):

    $allowedImageTypes = ["image/png", "image/jpeg", "image/webp"];
    $maxFileSize = 10 * 1024 * 1024;

    if(!in_array($_FILES["coverImage"]["type"], $allowedImageTypes)):
        die("Invalid image type");
    endif;
    if($_FILES["coverImage"]["size"] > $maxFileSize):
        die("file size is bigger than allowed size, 10MB");
    endif;
    if($_FILES["coverImage"]["error"] !== UPLOAD_ERR_OK):
        die("Error in file upload: " . $_FILES["coverImage"]["error"]);
    endif;

    $imgDir = "../media/images/";
    if(!file_exists($imgDir)):
        mkdir($imgDir, 0755, true);
    endif;

    $cleanImgFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES["coverImage"]["name"]));
    
    $imgDest = $imgDir . uniqid("img_", true) . "_" . $cleanImgFileName;
    if(is_uploaded_file($_FILES["coverImage"]["tmp_name"])):
        if(move_uploaded_file($_FILES["coverImage"]["tmp_name"], $imgDest)):
            echo "изображение $imgDest успешно записано в сервер<br/>";
        else:
            die("Failed to save file in server. cannot proceed");
        endif;
    else:
        die("error during file upload");
    endif;

    $imgDest = "/media/" . $imgDest;

    // connecting to database
    $username = "if0_39722397";
    $password = "pehBevo9Zxfx";
    $host = "sql101.infinityfree.com";
    $db = $username . "_zvelake";

    $connection = mysqli_connect($host, $username, $password, $db);
    if(!$connection):
        die("Failed to connect to database server");
    endif;

    $tableName = "NewsContent";
    $imgType = $_FILES["coverImage"]["type"];
    $newsDate = $_POST["newsDate"];

    $query = "INSERT INTO $tableName (coverImage, imageType, newsDate, newsContent, newsHeadline) VALUES
    ('$imgDest', '$imgType', '$newsDate', '" . $_POST["newsContent"]. "','" . $_POST["newsHeadline"]. "')";

    $queryResult = mysqli_query($connection, $query);
    if($queryResult):
        echo "Данные успешно записаны в базу данных<br/>";
    else:
        die("Не удалось загрузить данные в базу данных. попробуйте еще раз");
    endif;
else:
    die("Missing fields: coverImage, newsContent");
endif;
?>