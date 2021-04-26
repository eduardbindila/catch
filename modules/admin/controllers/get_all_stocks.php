<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "stock_products",
			"columns" => "*, stock_products.id as stock_id",
			"innerJoin" => "stock_locations on stock_products.location_id = stock_locations.id inner join products on stock_products.product_id = products.id",
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>