<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// var_dump($_POST);

if(isset($_POST['quote_id']))  {
	$where = "quote_files.quote_id = '".$_POST['quote_id']."'";
} else {
	$where = "`send_to_client` = 1 AND `is_sent` = 0";
}

if(isset($_SESSION['user_access']['admin'])) {
	$restrictQuotesByProfile = "";
} else {
	$restrictQuotesByProfile = " AND `assignee_id` = ".$_SESSION['user_id'];
}

// var_dump($where);


	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_files",
				"columns" => "quote_files.*, users.name, quote_file_types.name as file_type, quotes.assignee_id",
				"innerJoin" => "users ON quote_files.user_id = users.id INNER JOIN quote_file_types on quote_files.file_type = quote_file_types.id INNER JOIN quotes on quote_files.quote_id = quotes.id",
				"where" => $where.$restrictQuotesByProfile
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>