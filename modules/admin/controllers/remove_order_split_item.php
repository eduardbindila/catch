<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->delete(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items_split",
			"column" => "id",
			"in" => [$_POST['id']],
		)
	);

		echo json_encode($query);

	$QueryBuilder->closeConnection();


?>