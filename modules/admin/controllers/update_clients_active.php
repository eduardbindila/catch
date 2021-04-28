<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$clients_list = implode(',', $_POST['clients_list']);

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "clients",
			"set" => ["`active`=".$_POST['value']],
			"where" => "id in (".$clients_list.")"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>