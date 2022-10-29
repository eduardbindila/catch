<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$quote_items_list = implode(',', $_POST['quote_items']);

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`invoiced_quantity`=`quantity`","`reserved_stock`=0"],
			"where" => "id in (".$quote_items_list.")"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>