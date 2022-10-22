<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

 $isNotPackage = $_POST['package_id'] == '' && $_POST['package_status_id'] == '';

 echo $isNotPackage;

$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quote_comments",
			"keys" => ["quote_id", "user_id","status_id", "comment", "date", "package_id", "package_status_id"],
			"values" => [$_POST['data']['quote_id'], $_SESSION['user_id'], $_POST['quote_status'], $_POST['data']['comment'], strtotime('now'), ($isNotPackage ? 0 : $_POST['package_id']), ($isNotPackage ? 0 : $_POST['package_status_id'])]
		)
	);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>