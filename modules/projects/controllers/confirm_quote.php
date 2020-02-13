<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);
	if(isset($_POST['rejected_reason'])) {
		$rejected_reason = $_POST['rejected_reason'];
	} else {
		$rejected_reason = 0;
	}

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`".$_POST['flag']."`=1", "`rejected_reason`='".$rejected_reason."'"],
			"where" => "id = ".$_POST['quote_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>