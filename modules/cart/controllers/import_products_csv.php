<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

$when = '';

$ids = '';

$i = 0;

$valuesArray = [];

while(! feof($f_pointer)){
	$product=fgetcsv($f_pointer);

	if($product[0] && $product[1] && $product[2]) {
		$product_id = preg_replace("/[^a-zA-Z 0-9]+/", "",  trim($product[0]));

		$product_name = str_replace("'", "", str_replace('"', "", $product[1]));

		$initial_price = trim($product[2]);

		$manufacturer = preg_replace("/[^a-zA-Z 0-9]+/", "",   trim(substr($product[3], 0, 3)));

		$localArray = array(
			'product' => $product_id,
			'product_name' => $product_name,
			'initial_price' =>$initial_price,
			'manufacturer' => $manufacturer
		);

		array_push($valuesArray, $localArray);
	}	
}




$conn = $QueryBuilder->dbConnection();

	$productQuery = $QueryBuilder->insert(
            $conn,
            $options = array(
                "table" => "products",
                "keys" => ["id", "product_name", "initial_price", "manufacturer"],
                "values" => $valuesArray
            ),
            $multi = true,
        );

	echo json_encode($productQuery);
	
$QueryBuilder->closeConnection();




?>