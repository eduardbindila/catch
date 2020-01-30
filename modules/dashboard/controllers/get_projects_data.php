<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$isLocked = 1;

	$projectsQuery = $QueryBuilder->selectProjectsData($conn, $isLocked);


	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>