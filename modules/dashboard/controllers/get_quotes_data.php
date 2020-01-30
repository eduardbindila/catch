<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->selectQuotesData($conn, $_SESSION['is_client']);


	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>