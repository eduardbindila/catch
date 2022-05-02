<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$userId = basename($urlArray['path']);

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_name'])){ 

	$conn = $QueryBuilder->dbConnection();

	if(is_numeric($userId)) {
		
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "projects",
				"set" => [
					"`project_name`='".$_POST['project_name']."'",
					"`project_description`='".$_POST['project_description']."'",
					"`category_id`='".$_POST['project_category']."'",
					"`project_status`='".$_POST['project_status']."'",
					"`owner_id`='".$_POST['owner_id']."'"
					],
				"where" => "id =".$userId
			)
		);
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "projects",
				"keys" => ["project_name", "project_description", "category_id", "project_status", "owner_id"],
				"values" => [$_POST["project_name"], $_POST["project_description"], $_POST["project_category"], $_POST["project_status"], $_POST["owner_id"]]
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
$userQuery = 0;
if(is_numeric($userId)) {

	$conn = $QueryBuilder->dbConnection();

	$userQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "projects",
			"columns" => "*",
			"where" => 'id = '.$userId
		)
	);

	$QueryBuilder->closeConnection();

	
} 

include($_MPATH['ADMIN_VIEWS'].'add_project_form_view.php');		
?>