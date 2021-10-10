<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

$statusQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "count(*) as total, count(if(merge_status='1',1,null)) as not_needed, count(if(merge_status='2',1,null)) as needed, count(if(merge_status='4',1,null)) as quotes_modified, count(if(merge_status='5',1,null)) as quotes_error, count(if(merge_status='6',1,null)) as products_deactivated",
			"groupby" => "id"
		)
	);

	echo json_encode($statusQuery);

	$QueryBuilder->closeConnection();
?>