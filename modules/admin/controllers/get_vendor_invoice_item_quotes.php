<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$getQuotes = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_items qi",
			"columns" => "qi.quote_id, q.name, qi.id, qi.order_number, IFNULL(qi.ordered_quantity, 0) as ordered_quantity, (qi.quantity-IFNULL(qi.reserved_stock, 0)) as needed_quantity, qi.quantity as quoteQuantity, IFNULL(qi.reserved_stock, 0) as reserved_stock, products.saga_quantity, IFNULL(viis.quantity, 0) as split_quantity, viis.id as split_id,  IFNULL(vii.delivered_quantity, 0) as delivered_quantity,  (
        SELECT SUM(vendor_invoice_items_split.quantity) FROM vendor_invoice_items_split
        WHERE 
        vendor_invoice_items_split.vendor_invoice_item_id = '".$_POST['vendor_invoice_item_id']."'
    ) AS connected_total",
			"innerJoin" => " quotes q on qi.quote_id = q.id 
			inner join products on products.id = qi.product_id 
			inner join vendor_invoice_items vii on products.id = vii.product_id and vii.id = '".$_POST['vendor_invoice_item_id']."'
			left join vendor_invoice_items_split viis on viis.vendor_invoice_item_id = '".$_POST['vendor_invoice_item_id']."' and qi.id = viis.quote_item_id",
			"where" => "qi.product_id  = '".$_POST['product_id']."' AND q.quote_status = 10 AND qi.order_number is not null"
		)
	);


	echo json_encode($getQuotes);

	$QueryBuilder->closeConnection();
?>
