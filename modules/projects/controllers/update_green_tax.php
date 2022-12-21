<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();



	if($_POST['product_id'] == "") {
		$params = array(
			"table" => "package_items",
			"set_column" => "external_item_green_tax_id",
			"condition_column" => $_POST['package_item']
		);

	} else {
		$params = array(
			"table" => "products",
			"set_column" => "green_tax_id",
			"condition_column" => $_POST['product_id']
		);
	}


	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => $params["table"],
			"set" => [$params["set_column"]."=".$_POST['green_tax_id']],
			"where" => "id = '".$params["condition_column"]."'"
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>