<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "package_items",
				"columns" => "package_items.*, products.product_name, products.saga_quantity, quote_items.reserved_stock",
				"innerJoin" => 'quote_items on package_items.quote_item_id = quote_items.id inner join products on quote_items.product_id = products.id',
				"where" => "package_id = '".$_POST['package_id']."'"
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>