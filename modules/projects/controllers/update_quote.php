<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

if(isset($_POST['extra_discount'])) {
	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`extra_discount`='".$_POST['extra_discount']."'"],
			"where" => "id = ".$_POST['quote_id']
		)
	);
} elseif(isset($_POST['hide_discount'])) {

	//var_dump((int)($_POST['hide_discount'] === "true"));

	
	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`hide_discount`='".(int)($_POST['hide_discount'] === "true")."'"],
			"where" => "id = ".$_POST['quote_id']
		)
	);
}
	else {

//var_dump($_POST);

	if(isset($_POST['options']['flag'])) {

		$projectsQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quotes",
				"set" => ["`".$_POST['options']['flag']."` ='".+$_POST['options']['flag_value']."'"],
				"where" => "id = ".$_POST['quote_id']
			)
		);


	} else {
		$client_id = 'NULL';

		if(isset($_POST['options']['client_id'])) {
			if($_POST['options']['client_id'] == 0) {
				$client_id = 'NULL';
			} else {
				$client_id = $_POST['options']['client_id'];
			}
		}

		$projectsQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quotes",
				"set" => ["`name`='".$_POST['options']['name']."'","`profit`=".$_POST['options']['profit']."","`profit_percent`=".$_POST['options']['profit_percent']."","`quote_price`=".$_POST['options']['final_price']."","`assignee_id`=".$_POST['options']['assignee_id']."","`client_id`=".$client_id.""],
				"where" => "id = ".$_POST['quote_id']
			)
		);
	}
}





	echo json_encode($projectsQuery);

	$QueryBuilder->closeConnection();
?>