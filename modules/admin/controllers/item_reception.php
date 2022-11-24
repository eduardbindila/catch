<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);

$ids = [];

$whens = '';
$quoteItems = '';
$quoteItemCondition = '';

$freeStock = "0";

$newStock = "0";

$remainingStock = "0";


if($_POST['is_inverse']) {
	$reception = 0;
} else {
	$reception = 1;
}

$newReservedStock = "0";

if(isset($_POST['quoteItems'])) {
	foreach ($_POST['quoteItems'] as $key => $value) {

		array_push($ids, $value['id']);

		$newReservedStock = $value['reserved_stock'] + $value['split_quantity'];

		$freeStock = $value['delivered_quantity'] - ($value['connected_total'] ? $value['connected_total'] : 0);

		if($_POST['is_inverse']) {
			$newStock = $value['saga_quantity'] - $freeStock;
		} else {
			$newStock = $value['saga_quantity'] + $freeStock;
		}


		$remainingStock = $freeStock;


		if($_POST['is_inverse']){
			$whens = $whens.' when '.$value['id'].' then GREATEST(qi.quantity - qi.ordered_quantity, 0)' ;
		} else {
			$whens = $whens.' when '.$value['id'].' then '.$newReservedStock;
		}

	}

	$quoteItems = "qi.reserved_stock = case qi.id 
									".$whens."
									end,";

	$quoteItemCondition = "qi.id in (".implode(",",$ids).") and";


} else {

	$invoiceData = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoice_items vii",
			"columns" => "vii.id as id, products.saga_quantity,  IFNULL(vii.delivered_quantity, 0) as delivered_quantity",
			"innerJoin" => "products on vii.product_id = products.id",
			"where" => "vii.id=".$_POST['item_id']
		)
	);

	$freeStock = $invoiceData[0]['delivered_quantity'] ;

	

	if($_POST['is_inverse']) {
		$newStock = $invoiceData[0]['saga_quantity'] - $freeStock;
	} else {
		$newStock = $invoiceData[0]['saga_quantity'] + $freeStock;
	}

}


if($_POST['is_inverse']) {
	$remainingStock = 0;
} else {
	$remainingStock = $freeStock;
}


$query = "update quote_items qi, products p, vendor_invoice_items vii
			SET
			".$quoteItems."
				p.saga_quantity = case p.id 
			    				when '".$_POST['product_id']."' then ".$newStock."
			                    end,
				vii.reception = case vii.id 
			    				when ".$_POST['item_id']." then ".$reception."
			                    end,
			    vii.remaining_stock = case vii.id 
			    				when ".$_POST['item_id']." then ".$remainingStock."
			                    end
			where ".$quoteItemCondition." p.id in ('".$_POST['product_id']."') and vii.id in (".$_POST['item_id'].")";

//echo $query;

	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);


// printError($valuesArray);
  		echo$conn->error;


echo  json_decode($projectsQuery);

	$QueryBuilder->closeConnection();


?>