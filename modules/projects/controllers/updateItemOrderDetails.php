<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	echo "`".$_POST['name']."`=".$_POST['value']."";

	// $projectsQuery = $QueryBuilder->update(
	// 	$conn,
	// 	$options = array(
	// 		"table" => "quote_items",
	// 		"set" => ["`discount`=".$_POST['discount']."","`quantity`=".$_POST['quantity']."","`unit_price`=".$_POST['unit_price'].""],
	// 		"where" => "id = ".$_POST['item_id']
	// 	)
	// );


	// echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>