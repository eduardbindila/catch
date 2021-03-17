<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_SESSION['user_access']);


$profitPercent = '`profit_percent` > 30 AND ';
$restrictQuotesByProfile = " AND `assignee_id` = ".$_SESSION['user_id'];


//Show only Contracting quotes for logistic
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 7) { 
	$where = "`quote_status` = 5";

} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 5) {
	$restrictQuotesByProfile = "";
	$where = "(".$profitPercent."`quote_status` = 7) OR (`quote_status` = 5) OR (`quote_status` = 3 AND `client_approved` = 1)".$restrictQuotesByProfile;

} elseif(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 6) {

	$restrictQuotesByProfile = "";

	$where = "(".$profitPercent."`quote_status` = 7) OR (`quote_status` = 3 AND `client_approved` = 1)".$restrictQuotesByProfile;
}

 else {
	$where = "(".$profitPercent."`quote_status` = 7) OR (`quote_status` = 3 AND `client_approved` = 1)".$restrictQuotesByProfile;	
}

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quotes",
			"columns" => "quotes.*, projects.project_name, projects.id as project_id, clients.name as client_name, quote_status.name as status",
			"innerJoin" => "clients ON clients.id = quotes.client_id INNER JOIN projects ON quotes.project_id = projects.id INNER JOIN quote_status on quotes.quote_status = quote_status.id",
			"where" => $where
		)
	);

	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>