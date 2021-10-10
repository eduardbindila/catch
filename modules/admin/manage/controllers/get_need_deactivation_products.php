<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$count = "COUNT(*)";

$where = "pm.active = 1";

if($_POST['type'] == "merge"){
	$field = "merged_id";
} else if($_POST['type'] = "legacy") {
	$field = "legacy_id";
}


$conn = $QueryBuilder->dbConnection();

	$affectedQuoteItems = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products as p",
			"columns" => $count." as total",
			"innerJoin" => "products as pm on p.".$field." = pm.id",
			"where" => $where
		)
	);



//SELECT count(*) FROM `products` as p inner join products as pm on p.merged_id = pm.id where pm.active = 1

//update products as pd join ( SELECT p.merged_id FROM `products` as p inner join products as pm on p.merged_id = pm.id where pm.active = 1 ) as pm on pd.id = pm.merged_id set pd.active = 0

	echo json_encode($affectedQuoteItems);

	$QueryBuilder->closeConnection();
?>