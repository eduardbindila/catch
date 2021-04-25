<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	$conn = $QueryBuilder->dbConnection();

	if (!isset($_POST['client_id']))
		$_POST['client_id'] = 0;

	if(is_numeric($userId)) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "stock_locations",
				"set" => [
					"`row_name`='".$_POST['row_name']."'",
					"`column_name`='".$_POST['column_name']."'",
					],
				"where" => "id =".$userId
			)
		);
	} else {


		$locationExists = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "stock_locations",
				"columns" => "*",
				"where" => "row_name = '".$_POST["row_name"]."' AND column_name = '".$_POST["column_name"]."'",
			),
			$returnType = 'bol'
		);

		if($locationExists == false){
			$query = $QueryBuilder->insert(
				$conn,
				$options = array(
					"table" => "stock_locations",
					"keys" => ["row_name", "column_name"],
					"values" => [$_POST["row_name"], $_POST["column_name"]],

				),
				$multi = false
			);
		} else {
			$query = 0;
		}
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
			"table" => "stock_locations",
			"columns" => "*",
			"where" => "id =".$userId
		)
	);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'stock_location_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'stock_locations_view.php');
}
	
?>