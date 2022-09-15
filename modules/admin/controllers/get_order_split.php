<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items_split viis",
			"columns" => "viis.id, viis.quote_item_id, viis.quantity, qi.id as quote_item_id, qi.order_number",
			"innerJoin" => 'quote_items qi on qi.id = viis.quote_item_id',
			"where" => "vendor_invoice_item_id=".$_POST['vendor_invoice_item_id']." and qi.order_number='".$_POST['order_number']."'"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>