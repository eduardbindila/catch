<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if(isset($_SESSION['user_access']['admin'])) {
	$restrictQuotesByProfile = "id > 0 ";
} else {
	$restrictQuotesByProfile = "`user_id` = '".$_SESSION['user_id']."'";
}

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "clients",
			"columns" => "*",
			"where" => $restrictQuotesByProfile,
			"orderBy" => "name",
			"orderType" => "ASC"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>