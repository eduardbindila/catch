<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	$conn = $QueryBuilder->dbConnection();

	if(is_numeric($userId)) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "countries",
				"set" => [
					"`name`='".$_POST['name']."'",
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "countries",
				"keys" => ["name", "id"],
				"values" => [$_POST["name"], $_POST["id"]]
			),
			$multi = false
		);
	}

	$insertResult = json_decode($query);

	if($insertResult > 0) {
		$insertResult = $insertResult;
	} else {
		$insertResult = 0;
	}

	$QueryBuilder->closeConnection();
}

if(is_numeric($userId)) {

	$conn = $QueryBuilder->dbConnection();

	$userQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "countries",
			"columns" => "*",
			"where" => 'id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'countries_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'countries_view.php');
}
	
?>