<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "stock_products",
			"columns" => "*",
			"innerJoin" => "stock_locations on stock_products.location_id = stock_locations.id",
			"where" => "`product_id` = '".$_POST['product_id']."'"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>