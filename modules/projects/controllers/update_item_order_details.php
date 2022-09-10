<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`".$_POST['name']."`='".$_POST['value']."'"],
			"where" => "id = ".$_POST['item_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>