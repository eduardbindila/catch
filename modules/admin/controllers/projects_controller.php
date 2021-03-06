<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';
$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$host = "http://{$_SERVER['HTTP_HOST']}";

$userId = basename($actual_link);

$urlArray = parse_url($actual_link);

$userId = basename($urlArray['path']);

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
				"keys" => ["project_name", "project_description", "project_status", "owner_id"],
				"values" => [$_POST["project_name"], $_POST["project_description"], $_POST["project_status"], $_POST["owner_id"]]
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