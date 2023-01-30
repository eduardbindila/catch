<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

$exchange_rate = $_POST['exchange_rate'];


if($_POST["isRon"]) {
	$operator = "/";

	$newIsRon = 0;
	$newExchangeRate = $exchange_rate;
} else {
	$operator = "*";
	$newIsRon = 1;
	$newExchangeRate = "NULL";
}

$unit_price = 'TRUNCATE((
	         quote_items.unit_price '.$operator.' '.$exchange_rate. '
	), 2)';


$aquisition_price = 'TRUNCATE((
	         quote_items.aquisition_price '.$operator.' '.$exchange_rate. '
	), 2)';

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`unit_price`=".$unit_price."", "`aquisition_price`=".$aquisition_price.""],
			"where" => "quote_id = '".$_POST['quote_id']."'"
		)
	);

if($projectsQuery) {
		$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`exchange_rate`=".$newExchangeRate."", "`isRon`=".$newIsRon.""],
			"where" => "id = '".$_POST['quote_id']."'"
		)
	);
}

// $new_euro_unit_price = $_POST['target_price'] / $_POST['exchange_rate'];


// $new_euro_unit_price;

// 	$projectsQuery = $QueryBuilder->update(
// 		$conn,
// 		$options = array(
// 			"table" => "quote_items",
// 			"set" => ["`unit_price`=".$new_euro_unit_price.""],
// 			"where" => "id = '".$_POST['quote_item_id']."'"
// 		)
// 	);
echo $conn->error;

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>