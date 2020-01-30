<?php

require_once('../../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

$when = '';

$ids = '';

$i = 0;


$valuesArray = [];

while(! feof($f_pointer)){

	$product=fgetcsv($f_pointer);

		$localArray = array(
			'product_id' => trim($product[0]),
		);

		array_push($valuesArray, $localArray);
}

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "import_products_list",
			"keys" => ["id"],
			"values" => $valuesArray
		),
		$multi = true
	);


echo  json_decode($query);

	$QueryBuilder->closeConnection();

?>