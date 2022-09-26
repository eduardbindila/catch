<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items_split viis",
			"columns" => "viis.id, viis.quote_item_id, viis.quantity, 
			qi.id as quote_item_id, qi.order_number, qi.reserved_stock, qi.quote_id, qi.quantity as quoteQuantity",
			"innerJoin" => 'quote_items qi on qi.id = viis.quote_item_id',
			"where" => "vendor_invoice_item_id=".$_POST['vendor_invoice_item_id']." and qi.order_number='".$_POST['order_number']."' and viis.quote_item_id='".$_POST['quote_item_id']."'"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>