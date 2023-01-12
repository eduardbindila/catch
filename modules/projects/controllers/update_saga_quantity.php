<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products",
			"set" => ["`saga_quantity`=".$_POST['saga_quantity'].""],
			"where" => "id = '".$_POST['product_id']."'"
		)
	);
echo $conn->error;

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>