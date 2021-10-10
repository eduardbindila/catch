<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$count = "COUNT(qim.product_id)";

if($_POST['type'] == "merge"){
	$field = "merged_id";
	$where = "p.merged_id != 0 and merge_status = 2";

} else if($_POST['type'] = "legacy") {

	$field = "legacy_id";
	$where = "p.legacy_id is not null";

}


$conn = $QueryBuilder->dbConnection();

	$affectedQuoteItems = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products as p",
			"columns" => $count." as total",
			"innerJoin" => "quote_items as qim on p.".$field." = qim.product_id",
			"where" => $where
		)
	);


	//SELECT COUNT(qim.product_id) from products as p INNER join quote_items as qim on p.merged_id = qim.product_id where p.merged_id != 0 and merge_status = 2


	//SELECT COUNT(qim.product_id) from products as p INNER join quote_items as qim on p.legacy_id = qim.product_id where p.legacy_id is not null


	echo json_encode($affectedQuoteItems);

	$QueryBuilder->closeConnection();
?>