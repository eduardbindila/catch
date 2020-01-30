<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "projects",
			"keys" => ["project_name", "project_description", "owner_id"],
			"values" => [$_POST['project_name'], $_POST['project_description'], $_POST['owner_id']]
		)
	);


echo  json_decode($query);

	$QueryBuilder->closeConnection();


?>