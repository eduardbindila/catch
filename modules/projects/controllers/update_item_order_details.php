<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if(isset($_POST['reserved_stock'])) {
	$reserve_stock = ",`reserved_stock`='".$_POST['reserved_stock']."'";
}
else {
	$reserve_stock = '';
}

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`".$_POST['name']."`='".$_POST['value']."'".$reserve_stock],
			"where" => "id = ".$_POST['item_id']
		)
	);



	if($projectsQuery && isset($_POST['stock'])) {
		$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products",
			"set" => ["`saga_quantity`='".$_POST['stock']."'"],
			"where" => "id = '".$_POST['product_id']."'"
		)
	);
	}

	echo $conn->error;


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>