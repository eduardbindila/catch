<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_SESSION['user_access']);

if(isset($_SESSION['user_access']['admin'])) {
	$profitPercent = '';
} else {
	$profitPercent = '`profit_percent` > 30 AND ';
}


$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quotes",
			"columns" => "*",
			"where" => $profitPercent."`quote_status` = 7"
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>