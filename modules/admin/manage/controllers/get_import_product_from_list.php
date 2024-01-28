<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


//var_dump($_POST);

$conn = $QueryBuilder->dbConnection();

	$productsListQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products_import as pi",
			"columns" => "pi.id as id, pi.product_id as product_id, pi.saga_quantity as saga_stock, pi.saga_comment, pi.new_product_id, pi.price, pi.name as product_name, pi.manufacturer, pi.old_price, pi.comment, pis.name as status_name, pi.status as status, pi.nc_code, pi.active",
			"innerJoin" => "product_import_statuses as pis on pi.status = pis.id",
			"where" => "import_product_list_id ='".$_POST['listID']."' ",
			"columnAsGroup" => "status_name"
		)
	);

	echo json_encode($productsListQuery);

	$QueryBuilder->closeConnection();
?>