<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->delete(
		$conn,
		$options = array(
			"table" => "packages",
			"column" => "id",
			"in" => [$_POST['id']],
		)
	);

	$query = $QueryBuilder->delete(
		$conn,
		$options = array(
			"table" => "package_items",
			"column" => "package_id",
			"in" => [$_POST['id']],
		)
	);


		echo json_encode($query);

	$QueryBuilder->closeConnection();


?>