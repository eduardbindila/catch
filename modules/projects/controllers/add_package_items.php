<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	$valuesArray = [];

	//var_dump($_POST);

		foreach ($_POST['quote_items'] as $key => $value) {
			$localArray = array(
				'quote_item_id' => $value,
				'package_id' => $_POST['package_id'],
			);

			array_push($valuesArray, $localArray);
		}

	// var_dump($valuesArray);

	
$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "package_items",
			"keys" => ["quote_item_id", "package_id"],
			"values" => $valuesArray
		),
		$multi = true
	);


//printError($valuesArray);
//		echo$conn->error;


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>