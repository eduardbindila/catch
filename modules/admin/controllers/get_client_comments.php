<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "client_comments",
				"columns" => "client_comments.id, users.name, client_comments.comment, client_comments.date",
				"innerJoin" => "users ON client_comments.user_id = users.id",
				"where" => "client_comments.client_id = '".$_POST['client_id']."'"
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>