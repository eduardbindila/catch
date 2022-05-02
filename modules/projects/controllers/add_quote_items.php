<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	$valuesArray = [];

	// var_dump($_POST);

	if($_POST['isMulti']) {

		foreach ($_POST['products'] as $key => $value) {
			$localArray = array(
				'product' => $value['id'],
				'quote_id' => $_POST['quote_id'],
				'temporary_product' => $value['temporary_product'],
				'quantity' => $_POST['allProductsData'][$value['id']]['quantity']
			);

			array_push($valuesArray, $localArray);
		}

	} else {
		if(isset($_POST['temporary_products'])) {
		$temporary_product = $_POST['temporary_products'];
			}
			else {
				$temporary_product = 0;
			}

		foreach ($_POST['products'] as $key => $value) {
			$localArray = array(
				'product' => $value,
				'quote_id' => $_POST['quote_id'],
				'initial_price'=> 0,
				'discount' => $_SESSION['client_discount'],
				'temporary_product' => $temporary_product,
				'quantity' => $_POST['allProductsData'][$value]['quantity']
			);

			array_push($valuesArray, $localArray);
		}

	}

	// var_dump($valuesArray);

	
$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quote_items",
			"keys" => ["product_id", "quote_id", 'initial_price', 'discount', 'temporary_product', 'quantity'],
			"values" => $valuesArray
		),
		$multi = true
	);


// printError($valuesArray);
// 		echo$conn->error;


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>