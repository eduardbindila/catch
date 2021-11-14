<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();



	$query = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "*",
			"where" => "parent_id = '".$_POST['parent_id']."'"
		)
	);


	echo json_decode($query);

	$QueryBuilder->closeConnection();


?>