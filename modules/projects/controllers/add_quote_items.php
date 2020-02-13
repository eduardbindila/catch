<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	$valuesArray = [];

	//var_dump($_POST);

		foreach ($_POST['products'] as $key => $value) {
			$localArray = array(
				'product_id' => $value['id'],
				'quote_id' => $_POST['quote_id'],
				'temporary_product' => $_POST['temporary_products'],
				'initial_price' => $value['initial_price']
			);

			array_push($valuesArray, $localArray);
		}

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quote_items",
			"keys" => ["product_id", "quote_id", 'temporary_product', 'initial_price'],
			"values" => $valuesArray
		),
		$multi = true
	);


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>