<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products",
			"set" => ["`green_tax_id`=".$_POST['green_tax_id']],
			"where" => "id = '".$_POST['product_id']."'"
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>