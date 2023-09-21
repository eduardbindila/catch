<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	// printError($_POST);

	$conn = $QueryBuilder->dbConnection();
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "options",
				"set" => [
					"`name`='".$_POST['name']."'",
					"`value`='".$_POST['value']."'"
					],
				"where" => "id =".$_POST['id']
			)
		);



	$insertResult = json_decode($query);

	if($insertResult > 0) {
		$insertResult = $insertResult;
	} else {
		$insertResult = 0;
	}

	//printError($insertResult);

	$QueryBuilder->closeConnection();
}





include($_MPATH['ADMIN_VIEWS'].'control_panel_view.php');	

?>