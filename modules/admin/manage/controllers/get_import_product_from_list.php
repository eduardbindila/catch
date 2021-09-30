<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$productsListQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products_import",
			"columns" => "*",
			"where" => "import_product_list_id = 2",
			"columnAsGroup" => "status"
		),
		$returnType = "columnAsGroup"
	);

	echo json_encode($productsListQuery);

	$QueryBuilder->closeConnection();
?>