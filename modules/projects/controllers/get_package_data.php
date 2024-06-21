<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);


	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "packages_data",
				"columns" => "*",
				"where" => "package_id = '".$_POST['package_id']."'",
				"orderBy" => 'no_crt',
				"orderType" => 'ASC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>

