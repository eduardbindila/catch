<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

if($_POST['package_item_id'] > 0) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "package_items",
				"set" => ["`external_item_name`='".$_POST['external_item_name']."'"],
				"where" => "id = ".$_POST['package_item_id']
			)
		);
}
else {
	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "package_items",
			"keys" => ["package_id", "external_item_name"],
			"values" => [$_POST['package_id'], $_POST['external_item_name']]
		)
	);
 }
	


	// print_r($conn->error);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>