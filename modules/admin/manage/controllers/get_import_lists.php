<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$importListsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"columns" => "import_product_list.*, users.name as user, statuses.name as status",
			"innerJoin" => "users on import_product_list.user_id = users.id INNER JOIN import_product_list_statuses as statuses on import_product_list.status_id = statuses.id",
			"orderBy" => "date_uploaded",
			"orderType" => "DESC"
		)
	);

	echo json_encode($importListsQuery);

	$QueryBuilder->closeConnection();
?>