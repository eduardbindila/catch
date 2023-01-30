<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// var_dump($_POST);

$new_euro_unit_price = $_POST['target_price'] / $_POST['exchange_rate'];


$new_euro_unit_price;

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`unit_price`=".$new_euro_unit_price.""],
			"where" => "id = '".$_POST['quote_item_id']."'"
		)
	);
echo $conn->error;

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>