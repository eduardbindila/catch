<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$projectsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items",
	        "columns" => "vendor_invoice_items.*, vendor_invoice_item_types.name as type_name, 
	            products.saga_quantity, (
	                SELECT SUM(vendor_invoice_items_split.quantity) 
	                FROM vendor_invoice_items_split
	                WHERE vendor_invoice_items_split.vendor_invoice_item_id = vendor_invoice_items.id
	            ) AS connected_total,
	            (
	select
		SUM(qi.reserved_stock)
	from
		quote_items qi 
	where
		qi.product_id = products.id ) as total_reserved_stock",
	        "innerJoin" => "products on vendor_invoice_items.product_id = products.id 
	            left join vendor_invoice_item_types on vendor_invoice_items.type = vendor_invoice_item_types.id",
	        "where" => "vendor_invoice_id=".$_POST['vendor_invoice_id'],
	        "orderBy" => "vendor_invoice_items.id",
	        "orderType" => "ASC" 
		)
	);



	echo json_encode(utf8ize($projectsQuery));

	$QueryBuilder->closeConnection();
?>