<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';


$url = "https://www.bnr.ro/nbrfxrates.xml";
$xml = simplexml_load_file($url);

$exchange_rate = 0;

foreach ($xml->children() as $second_gen) {

    foreach ($second_gen->children() as $third_gen) {

        foreach ($third_gen->children() as $fourth_gen) {

        	if($fourth_gen->attributes() == 'EUR')
            	$exchange_rate = $fourth_gen;
        }
    }
}



if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	printError($_POST);

	$conn = $QueryBuilder->dbConnection();

	if(is_numeric($userId)) {
		// $query = $QueryBuilder->update(
		// 	$conn,
		// 	$options = array(
		// 		"table" => "countries",
		// 		"set" => [
		// 			"`name`='".$_POST['name']."'",
		// 			],
		// 		"where" => "id =".$userId
		// 	)
		// );
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "vendor_invoices",
				"keys" => ["invoice_no", "vendor", "date", "due_date", "currency", "exchange_rate", "invoice_value", "invoice_file"],
				"values" => [$_POST["invoice_no"], $_POST["vendor_id"], $_POST["date"], $_POST["due_date"], $_POST["currency"], $_POST["exchange_rate"],$_POST["invoice_value"], $_POST['file_name']]
			),
			$multi = false
		);
	}

	$insertResult = json_decode($query);

	if($insertResult > 0) {
		$insertResult = $insertResult;
	} else {
		$insertResult = 0;
	}

	$QueryBuilder->closeConnection();
}

if(is_numeric($userId)) {

	$conn = $QueryBuilder->dbConnection();

	$invoiceQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoices",
			"columns" => "*",
			"where" => 'id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'vendor_invoice_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'vendor_invoices_view.php');
}
	
?>