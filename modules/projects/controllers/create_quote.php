<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');



$conn = $QueryBuilder->dbConnection();

if($_SESSION['user_type']== 3) {

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quotes",
			"keys" => ["name","assignee_id", "project_id", 'start_date', 'quote_status', 'client_id','hide_discount' ],
			"values" => [isset($_POST['quote_name']) ? $_POST['quote_name'] : '', $_SESSION['user_id'], $_POST['project'], date("Y-m-d") , '4', $_SESSION['is_client'], 1]
		)
	);
}
else {
	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quotes",
			"keys" => ["name","assignee_id", "project_id", 'start_date', 'quote_status', 'hide_discount'],
			"values" => [isset($_POST['quote_name']) ? $_POST['quote_name'] : '', $_SESSION['user_id'], $_POST['project'], date("Y-m-d") , '4', 1]
		)
	);
}
	echo $conn->error;


	echo  json_decode($query);

	$QueryBuilder->closeConnection();
?>
