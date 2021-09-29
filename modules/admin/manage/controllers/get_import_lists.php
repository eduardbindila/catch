<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$importListsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"columns" => "import_product_list.*, users.name as user, statuses.name as status, count(*) as total, count(if(status='1',1,null)) as pending, count(if(status='2',1,null)) as error, count(if(status='3',1,null)) as error_accepted, count(if(status='4',1,null)) as removed, count(if(status='5',1,null)) as updated, count(if(status='6',1,null)) as new",
			"innerJoin" => "users on import_product_list.user_id = users.id INNER JOIN import_product_list_statuses as statuses on import_product_list.status_id = statuses.id INNER JOIN products_import on products_import.import_product_list_id = import_product_list.id GROUP BY import_product_list.id",
			"orderBy" => "date_uploaded",
			"orderType" => "DESC"
		)
	);

	echo json_encode($importListsQuery);

	$QueryBuilder->closeConnection();
?>