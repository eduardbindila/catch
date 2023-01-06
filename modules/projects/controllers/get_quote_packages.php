<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "packages",
				"columns" => "packages.*, package_status.name, quotes.extra_discount",
				"innerJoin" => 'package_status on package_status_id = package_status.id 
				left join quotes on packages.quote_id = quotes.id',
				"where" => "quote_id = '".$_POST['quote_id']."'",
				"orderBy" => 'packages.id',
				"orderType" => 'DESC'
			)
		);

	echo json_encode($query);

	$QueryBuilder->closeConnection();
?>