<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "projects",
			"set" => ["`master_quote`=".$_POST['quote_id'].""],
			"where" => "id = ".$_POST['project_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>