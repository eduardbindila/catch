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
				"table" => "specifyer_designer",
				"set" => [
					"`name`='".$_POST['name']."'",
					"`email`='".$_POST['email']."'",
					"`phone`='".$_POST['phone']."'"
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "specifyer_designer",
				"keys" => ["name", "email", "phone"],
				"values" => [$_POST["name"], $_POST["email"], $_POST["phone"]]
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
			"table" => "specifyer_designer",
			"columns" => "*",
			"where" => 'specifyer_designer.id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'designer_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'designers_view.php');
}
	
?>