<?php
require_once('../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$uploadedName = preg_replace("/[^a-zA-Z0-9.]+/", "-", $_FILES['file']['name']);

// var_dump($_FILES['file']['name']);

// var_dump($uploadedName);

$target_file = $target_dir . $uploadedName;

$strtotime = strtotime("now");
$filename = $strtotime.'_'.$uploadedName;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$filename)) {
   $status = 1;
  echo  $filename;
}
?>