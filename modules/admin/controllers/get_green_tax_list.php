<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$greenTaxList = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "green_tax",
			"columns" => "*",
		)
	);

	echo json_encode(utf8ize($greenTaxList));

	$QueryBuilder->closeConnection();
?>