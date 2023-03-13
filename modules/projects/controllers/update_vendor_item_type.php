<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();



	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items",
			"set" => [" type =".$_POST['item_type_id']],
			"where" => "id = '".$_POST['vendor_item']."'"
		)
	);

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>