<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();


$getLatestListId = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"columns" => "max(id) as latest_list_id"
		)
	);


$statusQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products_import",
			"columns" => "count(*) as total,  count(if(status='7',1,null)) as waiting_update, count(if(status='9',1,null)) as waiting_merge, count(if(status='2',1,null)) as error, count(if(status='8',1,null)) as legacy_updated",
			"where" => "import_product_list_id = ".$getLatestListId[0]['latest_list_id'],
			"groupby" => "id"
		)
	);

echo json_encode($statusQuery);

	$QueryBuilder->closeConnection();
?>