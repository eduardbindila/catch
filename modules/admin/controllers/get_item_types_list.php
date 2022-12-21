<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$packageItemTypes = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "package_item_types",
			"columns" => "*",
		)
	);

	echo json_encode(utf8ize($packageItemTypes));

	$QueryBuilder->closeConnection();
?>