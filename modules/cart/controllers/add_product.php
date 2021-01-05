<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();



	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "products",
			"keys" => ["id", "product_name", "initial_price"],
			"values" => [$_POST['id'], $_POST['product_name'], $_POST['initial_price']]
		)
	);


	echo json_decode($query);

	$QueryBuilder->closeConnection();


?>