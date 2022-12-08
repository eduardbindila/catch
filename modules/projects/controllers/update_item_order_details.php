<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$reserve_stock = '';
$conn = $QueryBuilder->dbConnection();

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



		$newReserve = ($quoteItemsQuery[0]['quantity'] - $_POST['value']);

		//echo $newReserve;

		$itemStock = (int)$quoteItemsQuery[0]['saga_quantity'] + (int)$quoteItemsQuery[0]['reserved_stock'];

		//echo $itemStock;

        $newStock = 0;
                

        if(($newReserve >= 0) && ($itemStock >= $newReserve))  {
            $newReserve = $newReserve;
            $newStock = $itemStock - $newReserve;
        } 
        else {
            $newReserve = $itemStock;
            $newStock = 0;
        }


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

	//echo "  ".$newReserve.' '.$newStock;


	


	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quote_items",
			"set" => ["`".$_POST['name']."`='".$_POST['value']."'".$reserve_stock],
			"where" => "id = ".$_POST['item_id']
		)
	);


	$params['result'] = $projectsQuery;

	echo $conn->error;


	echo json_encode($params);

	$QueryBuilder->closeConnection();
?>