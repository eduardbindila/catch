<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items",
			"columns" => "vendor_invoice_items.*, products.saga_quantity",
			"innerJoin" => "products on vendor_invoice_items.product_id = products.id",
			"where" => "vendor_invoice_id=".$_POST['vendor_invoice_id'],
			"orderBy" => "vendor_invoice_items.id",
			"orderType" => "ASC"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>