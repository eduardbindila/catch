<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();
	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items",
			"columns" => "*",
			"innerJoin" => "quotes ON quote_items.quote_id = quotes.id INNER JOIN projects ON quotes.project_id = projects.id",
			"where" => "quotes.client_id = '".$_POST['client']."' AND quote_items.product_id = '".$_POST['product']."'"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>

