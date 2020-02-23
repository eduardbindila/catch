<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$host = "http://{$_SERVER['HTTP_HOST']}";

$urlArray = parse_url($actual_link);

$quoteID = basename($urlArray['path']);

$conn = $QueryBuilder->dbConnection();

	$quote = $QueryBuilder->selectQuoteData($conn, $quoteID);

	$quoteItems = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items",
			"columns" => "quote_items.*, products.product_image ",
			"innerJoin" => " products ON products.id = quote_items.product_id",
			"where" => "quote_id = '".$quoteID."'"
		)
	);

	$quote = $quote[0];

	$quote['quote_items'] = $quoteItems;

	var_dump($quoteItems);

	$QueryBuilder->closeConnection();



include($_MPATH['QUOTES_VIEWS'].'quote_view.php');
?>