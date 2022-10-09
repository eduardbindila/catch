<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');





$conn = $QueryBuilder->dbConnection();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "packages",
			"keys" => ["quote_id"],
			"values" => [$_POST['quote_id']]
		)
	);

//printError($_POST);
 //		echo$conn->error;


	echo  json_decode($query);

	$QueryBuilder->closeConnection();
?>