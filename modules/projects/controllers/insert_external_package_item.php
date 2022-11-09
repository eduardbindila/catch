<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "package_items",
			"keys" => ["package_id", "external_item_name"],
			"values" => [$_POST['package_id'], $_POST['external_item_name']]
		)
	);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>