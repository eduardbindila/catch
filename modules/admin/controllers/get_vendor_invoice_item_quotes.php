<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$getQuotes = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items qi",
			"columns" => "qi.quote_id, q.name, qi.id ",
			"innerJoin" => " quotes q on qi.quote_id = q.id",
			"where" => "qi.product_id  = '".$_POST['product_id']."' AND q.quote_status = 2"
		)
	);


	echo json_encode($getQuotes);

	$QueryBuilder->closeConnection();
?>