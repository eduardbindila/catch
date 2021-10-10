<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$updatesQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"set" => ["`status_id`='".$_POST['new_status']."'"],
			"where" => "id = ".$_POST['id']
		)
	);

	echo json_encode($updatesQuery);

	$QueryBuilder->closeConnection();
?>