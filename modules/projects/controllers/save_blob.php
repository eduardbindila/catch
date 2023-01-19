<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


// print_r($_FILES);


// print_r($_POST);

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";

$filename = $_POST['file_name'].'.'.$_POST['file_extension'];

move_uploaded_file(
    $_FILES['data']['tmp_name'], 
    $target_dir.$filename
)

?>

