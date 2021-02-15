<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if(isset($_SESSION['user_access']['admin'])) {
	$restrictQuotesByProfile = "`owner_id` != 'NULL'";
} else {
	$restrictQuotesByProfile = "`owner_id` = '".$_SESSION['user_id']."'";
}

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "projects",
			"columns" => "id, project_name, project_description, owner_id",
			"where" => $restrictQuotesByProfile
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();

?>