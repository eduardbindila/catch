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

$valuesArray = array();

foreach ($quoteItemsQuery as $key => $quoteItem) {
	# code...

	array_splice($quoteItem, 0, 1);

	$quoteItem['quote_id'] = $_POST['quote_id'];

	array_push($valuesArray, $quoteItem);

}


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



	$QueryBuilder->closeConnection();


?>