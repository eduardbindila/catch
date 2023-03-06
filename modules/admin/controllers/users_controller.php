<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	$conn = $QueryBuilder->dbConnection();

	if (empty($_POST['client_id']))
		$_POST['client_id'] = 0;

	if(is_numeric($userId)) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "users",
				"set" => [
					"`name`='".$_POST['name']."'",
					"`email`='".$_POST['email']."'",
					"`username`='".$_POST['username']."'",
					"`password`='".$_POST['password']."'",
					"`type_id`='".$_POST['user_type']."'",
					"`phone`='".$_POST['phone']."'",
					"`isclient`='".$_POST['client_id']."'",
					"`active`='".$_POST['user_active']."'",
					"`kpi_igm`='".$_POST['kpi_igm']."'",
					"`kpi_selling_value`='".$_POST['kpi_selling_value']."'"
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "users",
				"keys" => ["name", "username", "email", "password", "type_id", "phone", "isclient", "active", "kpi_igm", "kpi_selling_value"],
				"values" => [$_POST["name"], $_POST["username"], $_POST["email"], $_POST["password"], $_POST["user_type"], $_POST["phone"], $_POST["client_id"], $_POST['user_active'], $_POST['kpi_igm'],$_POST['kpi_selling_value']]
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
			"table" => "users",
			"columns" => "*",
			"innerJoin" => 'user_types ON user_types.id = users.type_id',
			"where" => 'users.id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'user_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'users_view.php');
}
	
?>