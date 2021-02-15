<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	$conn = $QueryBuilder->dbConnection();

	if(is_numeric($userId)) {
		$discount = $_POST['discount']? $_POST['discount'] : '0.00' ;
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "clients",
				"set" => [
					"`name`='".$_POST['name']."'",
					"`email`='".$_POST['email']."'",
					"`user_id`='".$_POST['user']."'",
					"`fiscal_code`='".$_POST['fiscal_code']."'",
					"`country`='".$_POST['country']."'",
					"`phone`='".$_POST['phone']."'",
					"`state`='".$_POST['state']."'",
					"`address`='".$_POST['address']."'",
					"`bank_account`='".$_POST['bank_account']."'",
					"`registry`='".$_POST['registry']."'",
					"`bank`='".$_POST['bank']."'",
					"`discount`='".$discount."'"
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "clients",
				"keys" => ["name", "user_id", "email", "fiscal_code", "country", "registry", "phone", "state", "address", "bank", "discount"],
				"values" => [$_POST["name"], $_POST["user"], $_POST["email"], $_POST["fiscal_code"], $_POST["country"], $_POST["registry"], $_POST["phone"], $_POST["state"], $_POST["address"], $_POST["bank"], $_POST['discount']? $_POST['discount'] : '0.00']
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
			"table" => "regions",
			"columns" => "*",
			"where" => 'id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'regions_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'regions_view.php');
}
	
?>