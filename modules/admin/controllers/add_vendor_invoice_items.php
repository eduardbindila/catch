<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	$valuesArray = [];

	//printError($_POST);

	foreach ($_POST['products'] as $key => $value) {

		//var_dump($value);
		$localArray = array(
			'product_id' => $value,
			'vendor_invoice_id' => $_POST['vendor_invoice_id'],
			'quantity' => $_POST['allProductsData'][$value]['quantity'],
		);

		array_push($valuesArray, $localArray);
	}

	

	//printError($valuesArray);

	
$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items",
			"keys" => ["product_id", "vendor_invoice_id", 'quantity'],
			"values" => $valuesArray
		),
		$multi = true
	);


// // printError($valuesArray);
 		echo$conn->error;


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>