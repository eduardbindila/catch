<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "users",
			"columns" => "users.id, users.name, user_types.user_type_name",
			"innerJoin" => 'user_types ON user_types.id = users.type_id',
			"where" => "`type_id` != 4",
			"orderBy" => "users.name",
			"orderType" => "ASC"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>