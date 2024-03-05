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
					"`poi`='".$_POST['poi']."'",
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
					"`discount`='".$discount."'",
					"`saga_code`='".$_POST['saga_code']."'"
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "clients",
				"keys" => ["name", "poi", "user_id", "email", "fiscal_code", "country", "registry", "phone", "state", "address", "bank", "discount"],
				"values" => [$_POST["name"],$_POST["poi"], $_POST["user"], $_POST["email"], $_POST["fiscal_code"], $_POST["country"], $_POST["registry"], $_POST["phone"], $_POST["state"], $_POST["address"], $_POST["bank"], $_POST['discount']? $_POST['discount'] : '0.00', $_POST["saga_code"]]
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

	if(isset($_SESSION['user_access']['admin']) || isset($_SESSION['user_type']) && $_SESSION['user_type'] = 7) {
		$restrictQuotesByProfile = "";
	} else {
		$restrictQuotesByProfile = " AND `user_id` = ".$_SESSION['user_id'];
	}

	$conn = $QueryBuilder->dbConnection();

	$userQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "clients",
			"columns" => "*",
			"where" => 'id = '.$userId.$restrictQuotesByProfile 
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'client_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'clients_view.php');
}
	
?>