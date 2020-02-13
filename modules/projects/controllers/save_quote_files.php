<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();




	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quote_files",
			"keys" => ["quote_id", "file_path", "date", 'user_id'],
			"values" => [$_POST['quote_id'], $_POST['file_name'], strtotime('now'), $_SESSION['user_id']]
		)
	);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>