<?php
require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$target_file = $target_dir . basename($_FILES["file"]["name"]);

$strtotime = strtotime("now");
$filename = $strtotime.'_'.$_FILES['file']['name'];

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$filename)) {
   $status = 1;
  echo  $filename;
}
?>