<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items_split",
			"set" => ["`quantity`='".$_POST['quantity']."'"],
			"where" => "id = ".$_POST['id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>