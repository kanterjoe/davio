<?php
/**
 * Created by PhpStorm.
 * User: jkanter
 * Date: 2/26/17
 * Time: 2:32 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$target_dir = $_SERVER['DOCUMENT_ROOT']."/resources/audio/";
$target_file = $target_dir . basename($_FILES["audiofile"]["name"]);
$uploadOk = 1;
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists. $target_file";
    $uploadOk = 0;
}
else {
    if (move_uploaded_file($_FILES["audiofile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["audiofile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>