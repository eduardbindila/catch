<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quote_comments",
			"keys" => ["quote_id", "user_id","status_id", "comment", "date"],
			"values" => [$_POST['data']['quote_id'], $_SESSION['user_id'], $_POST['quote_status'], $_POST['data']['comment'], strtotime('now')]
		)
	);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>