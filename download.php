<?php 
require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$file = 'uploads/'.$_GET['f'];

var_dump($file);

if(isset($_GET['f'])) {

 	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($file) . "\""); 
	readfile($file);
}

?>



