<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_files",
				"columns" => "quote_files.file_path, users.name,  quote_files.date",
				"innerJoin" => "users ON quote_files.user_id = users.id",
				"where" => "quote_files.quote_id = '".$_POST['quote_id']."'"
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>