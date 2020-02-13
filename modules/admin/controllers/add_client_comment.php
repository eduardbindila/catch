<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "client_comments",
			"keys" => ["client_id", "user_id", "comment", "date"],
			"values" => [$_POST['client_id'], $_SESSION['user_id'], $_POST['data']['comment'], strtotime('now')]
		)
	);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>