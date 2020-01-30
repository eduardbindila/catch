<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`client_approved`=1"],
			"where" => "id = ".$_POST['quote_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>