<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//echo $_POST['product_id'];


$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items qi",
			"columns" => "distinct quote_id, q.name, qs.name as quote_status, q.project_id, p.project_name, sum(reserved_stock) as reserved_stock",
			"innerJoin" => "quotes q on q.id = qi.quote_id
							join quote_status qs on qs.id = q.quote_status
							join projects p on p.id = q.project_id",
			"where" => "product_id = '".$_POST['product_id']."'",
			"groupBy" => "qi.quote_id"
		)
	);


	//printError($query);

	echo json_encode($query);

	$QueryBuilder->closeConnection();


?>

