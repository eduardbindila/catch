<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items_split",
			"keys" => ["vendor_invoice_item_id", "quote_item_id", 'quantity'],
			"values" => [$_POST['vendor_invoice_item_id'], $_POST['quote_item_id'], $_POST['quantity']]
		)
	);


// printError($valuesArray);
//  		echo$conn->error;


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>