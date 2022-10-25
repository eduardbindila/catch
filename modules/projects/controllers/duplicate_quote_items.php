<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	
$conn = $QueryBuilder->dbConnection();

$quoteItemsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items",
			"columns" => "*",
			"where" => "id in (".$QueryBuilder->arrayToSql($_POST['quote_items'], "'").")"
		)
	);

$keys = array_keys($quoteItemsQuery[0]);

$keys = array_splice($keys, 1);

$keys = array_splice($keys,0, -6);

$valuesArray = array();

foreach ($quoteItemsQuery as $key => $quoteItem) {
	# code...

	
	$quoteItem['customer_description'] = addslashes($quoteItem['customer_description']);
	$quoteItem['destination'] = addslashes($quoteItem['destination']);

	array_splice($quoteItem, 0, 1);

	$quoteItem['quote_id'] = $_POST['quote_id'];
	unset($quoteItem['aquisition_price']);
	unset($quoteItem['reserved_stock']);
	unset($quoteItem['order_number']);
	unset($quoteItem['order_date']);
	unset($quoteItem['ordered_quantity']);
	unset($quoteItem['promise_date']);
	$quoteItem['rejection_reason'] = 1;
	array_push($valuesArray, $quoteItem);

}

//printError($valuesArray);

$inserQuoteItems = $QueryBuilder->insert(
    $conn,
    $options = array(
        "table" => "quote_items",
        "keys" => $keys,
        "values" => $valuesArray
    ),
    $multi = true
);


	echo  json_decode($inserQuoteItems);

	echo $conn->error;



	$QueryBuilder->closeConnection();


?>