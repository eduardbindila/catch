<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// $date = new DateTime();

// $product_id = 'T'.$date->getTimestamp();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "products",
			"keys" => ["id", "product_name", "product_description", "product_image", "initial_price", 'is_temporary'],
			"values" => [
				$_POST['id'],
				$_POST['product_name'], 
				$_POST['product_description'], 
				trim($_POST['file_name']),
				$_POST['initial_price'],
				'1'
			]
		)
	);
//var_dump($query);
	if ($query) {
		
		$addQuoteItem = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "quote_items",
				"keys" => ["product_id", "quote_id", "initial_price", "temporary_product"],
				"values" => [
					$_POST['id'], 
					$_POST['quote_id'], 
					$_POST['initial_price'],
					1
				]
			)
		);
		//var_dump($addQuoteItem);
	} else {
		$addQuoteItem = 0;
	}
	

	if ($query && $addQuoteItem)
    {
        header('Content-Type: application/json');
        print json_encode($addQuoteItem);
    }
else
    {
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('query' => $query, 'addQuoteItem' => $addQuoteItem)));
    }

	$QueryBuilder->closeConnection();


?>