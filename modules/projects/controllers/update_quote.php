<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();
	$client_id = 'NULL';

	if(isset($_POST['options']['client_id'])) {
		if($_POST['options']['client_id'] == 0) {
			$client_id = 'NULL';
		} else {
			$client_id = $_POST['options']['client_id'];
		}
	}


	//var_dump($_POST);

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`name`='".$_POST['options']['name']."'","`profit`=".$_POST['options']['profit']."","`profit_percent`=".$_POST['options']['profit_percent']."","`quote_price`=".$_POST['options']['final_price']."","`assignee_id`=".$_POST['options']['assignee_id']."","`client_id`=".$client_id.""],
			"where" => "id = ".$_POST['quote_id']
		)
	);


	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>