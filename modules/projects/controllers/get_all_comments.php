<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$allQuoteComments = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_comments",
				"columns" => "quotes.id, users.name, quote_status.name as status, quote_comments.comment, quote_comments.date",
				"innerJoin" => "users ON quote_comments.user_id = users.id INNER JOIN quotes ON quote_comments.quote_id = quotes.id INNER JOIN quote_status on quote_comments.status_id = quote_status.id INNER Join projects ON quotes.project_id = projects.id",
				"where" => "projects.id = '".$_POST['project_id']."'",
				"orderBy" => "quotes.id",
				"orderType" => "ASC"
			)
		);

	echo json_encode($allQuoteComments);

	$QueryBuilder->closeConnection();
?>