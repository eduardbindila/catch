<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();



	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "package_items",
			"set" => [" type =".$_POST['item_type_id']],
			"where" => "id = '".$_POST['package_item']."'"
		)
	);

	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>