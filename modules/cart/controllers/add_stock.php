<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "stock_products",
			"keys" => ["product_id", "quantity", "location_id"],
			"values" => [$_POST['id'], $_POST['quantity'], $_POST['location_id']]
		)
	);

	if($query) {
		$updateStockLocations = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "stock_locations",
				"set" => ["`in_use`='1'"],
				"where" => "id = ".$_POST['location_id']
			)
		);
	} 


	echo json_decode($query);

	$QueryBuilder->closeConnection();


?>