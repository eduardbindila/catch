<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


// print_r($_FILES);


// print_r($_POST);

$file = $_POST['file'];
$url = $_POST['url'];

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
 
$location = $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/products/".$file;
$content = file_get_contents($url, false, stream_context_create($arrContextOptions));
file_put_contents($location, $content);

$file_location =  'https://' . $_SERVER['HTTP_HOST'] . "/public/uploads/products/".$file;

echo json_encode($file_location);


?>

