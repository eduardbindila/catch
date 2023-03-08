<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

$vendorID =  urldecode($_GET['id']);


if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	//printError($_POST);

	$conn = $QueryBuilder->dbConnection();

	if($vendorID) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "vendors",
				"set" => [
					"`name`='".$_POST['name']."'","`code`='".$_POST['code']."'",
					],
				"where" => "id ='".$vendorID."'"
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "vendors",
				"keys" => ["name", "id", "code"],
				"values" => [$_POST["name"], $_POST["id"], $_POST["code"]]
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
//echo $conn->error;
	$QueryBuilder->closeConnection();
}

if($vendorID) {

	$conn = $QueryBuilder->dbConnection();

	$userQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendors",
			"columns" => "*",
			"where" => 'id = "'.$vendorID.'"'
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'vendor_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'vendors_view.php');
}
	
?>