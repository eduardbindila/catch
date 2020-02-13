<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

if(isset($_POST['client'])) {
	$client_id = 0;
} else {
	$client_id = $_SESSION['is_client'];
}

	$projectsQuery = $QueryBuilder->selectQuotesData($conn, $client_id);


	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>