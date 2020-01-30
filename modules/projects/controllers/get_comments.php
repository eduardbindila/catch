<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_comments",
				"columns" => "quote_comments.id, users.name, quote_status.name as status, quote_comments.comment, quote_comments.date",
				"innerJoin" => "users ON quote_comments.user_id = users.id INNER JOIN quote_status on quote_comments.status_id = quote_status.id",
				"where" => "quote_comments.quote_id = '".$_POST['quote_id']."'"
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>