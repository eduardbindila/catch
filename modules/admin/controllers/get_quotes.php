<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_SESSION['user_access']);

if(isset($_SESSION['user_access']['admin'])) {
	$profitPercent = '';
	$restrictQuotesByProfile = "";
} else {
	$profitPercent = '`profit_percent` > 30 AND ';
	$restrictQuotesByProfile = "AND `assignee_id` = ".$_SESSION['user_id'];
}


$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quotes",
			"columns" => "quotes.*, projects.project_name, projects.id as project_id, clients.name as client_name",
			"innerJoin" => "clients ON clients.id = quotes.client_id INNER JOIN projects ON quotes.project_id = projects.id",
			"where" => "(".$profitPercent."`quote_status` = 7 OR (`quote_status` = 3 AND `client_approved` = 1))".$restrictQuotesByProfile
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>