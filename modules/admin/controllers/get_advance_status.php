<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$advanceStatus = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "package_items pi",
			"columns" => "SUM(
								IF(pi.type = 2, pi.external_item_unit_price * pi.package_quantity, 0)
							) AS advance_sum,
							SUM(
								IF(pi.type = 3, pi.external_item_unit_price  * pi.package_quantity, 0)
							) AS reversal_sum",
			"innerJoin" => "packages p  on p.id = pi.package_id
							join quotes q on q.id = p.quote_id",
			"where" =>"q.id = ".$_POST['quote_id'],
			"groupby" => "q.id"
			)
		);

	echo json_encode(utf8ize($advanceStatus));

	$QueryBuilder->closeConnection();
?>