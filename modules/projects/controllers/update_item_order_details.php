<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$reserve_stock = '';

$setPostValue = "`".$_POST['name']."`='".$_POST['value']."'";
$conn = $QueryBuilder->dbConnection();

function notempty($var) {
    return ($var==="0"||$var);
}

$params = array(
	"reserved" => "",
	"stock" => "",
	'result' => ""

);


	if($_POST['name'] == 'ordered_quantity') {

		$quoteItemsQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_items qi",
				"columns" => "*",
				'innerJoin' => "products p on p.id = qi.product_id ",
				"where" => 'qi.id = '.$_POST['item_id']
			)
		);

		// print_r($quoteItemsQuery);

		// print_r($_POST);

		//echo $quoteItemsQuery[0]['quantity']. ' ' .$_POST['value'];

		$itemStock = (int)$quoteItemsQuery[0]['saga_quantity'] + (int)$quoteItemsQuery[0]['reserved_stock'];

		//echo notempty($_POST['value']);

		if(!notempty($_POST['value'])) { //NULL Order Quantity will reset the stock and reserved


			$newReserve = 0;

			$newStock = $itemStock;

			$setPostValue = "`".$_POST['name']."`= NULL";

		}else {
			$newReserve = ($quoteItemsQuery[0]['quantity'] - $_POST['value']);
			$newStock = 0;

			if(($newReserve >= 0) && ($itemStock >= $newReserve))  {
	            $newReserve = $newReserve;
	            $newStock = $itemStock - $newReserve;
	        } else if(($newReserve < 0) && ($itemStock >= $_POST['value']))
	        {
	        	$newReserve =  0;
	            $newStock = $itemStock;
	        }
	        else {
	            $newReserve = $itemStock;
	            $newStock = 0;
	        }
		}

		

		//echo $newReserve;

		
		//echo $itemStock;

        
        

		if($quoteItemsQuery) {
			$projectsQuery = $QueryBuilder->update(
				$conn,
				$options = array(
					"table" => "products",
					"set" => ["`saga_quantity`='".$newStock."'"],
					"where" => "id = '".$_POST['product_id']."'"
				)
			);


			$reserve_stock = ",`reserved_stock`='".$newReserve."'";
		}

		$params["reserved"] = $newReserve;
		$params["stock"] = $newStock;
	}

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => [$setPostValue.$reserve_stock],
			"where" => "id = ".$_POST['item_id']
		)
	);


	$params['result'] = $projectsQuery;

	echo $conn->error;


	echo json_encode($params);

	$QueryBuilder->closeConnection();
?>