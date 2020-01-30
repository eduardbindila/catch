<?php
require_once('../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if($_POST['image_url']) {
	$image_url = $_POST['image_url']
}else {
	$image_url = "http://ideyafoana.com/api/public/storage/photo/no-image.png";
}

$img = file_get_contents($image_url); 
  
// Encode the image string data into base64 
$data = base64_encode($img); 
  
// Display the output 
echo 'data:image/jpeg;base64,'.$data; 
?>