<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if($_POST['isMaster'] == 0) {
	$newMaster = 1;
} else {
	$newMaster = 0;
}

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`isMaster`='".$newMaster."'"],
			"where" => "id = ".$_POST['quote_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>