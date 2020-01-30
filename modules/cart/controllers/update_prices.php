<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

$when = '';

$ids = '';

$i = 0;

while(! feof($f_pointer)){
	$product=fgetcsv($f_pointer);

	$product_id = preg_replace("/[^a-zA-Z 0-9]+/", "",  trim($product[0]));

	$initial_price = trim($product[1]);
	
	if($product_id) {
		$newWhen = "WHEN id LIKE '".$product_id."' THEN '".$initial_price."' ";

		$when = $when.$newWhen;

		if($i == 0) {
			$sep = '';
		} else {
			$sep = ',';
		}



		$ids = $ids.$sep." '".$product_id."'";

		$i++;
	}
	
}



$query = "UPDATE `products` SET `initial_price`= CASE ".$when." END WHERE `id` IN (".$ids.");";

echo json_encode($query);

$conn = $QueryBuilder->dbConnection();

	$results = $conn->query($query);

	echo json_encode($results);
	
$QueryBuilder->closeConnection();




?>