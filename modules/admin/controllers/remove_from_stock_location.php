<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();


	
	$query = $QueryBuilder->delete(
		$conn,
		$options = array(
			"table" => "stock_products",
			"column" => "id",
			"in" => [$_POST['stock_id']]	
		)
	);

	if($query) {
		$updateStockLocations = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "stock_locations",
				"set" => ["`in_use`='0'"],
				"where" => "id = ".$_POST['location_id']
			)
		);
	} 


	echo json_decode($query);

	$QueryBuilder->closeConnection();


?>