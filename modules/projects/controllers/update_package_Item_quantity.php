<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);



		$getPackageItem = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_items",
				"columns" => "products.saga_quantity, quote_items.reserved_stock",
				"innerJoin" => 'products on quote_items.product_id = products.id',
				"where" => "quote_items.id = '".$_POST['quote_item_id']."'"
			)
		);

		$saga_quantity = is_numeric($getPackageItem[0]['saga_quantity']) ? $getPackageItem[0]['saga_quantity'] : 0 ;

		$reserved_stock = is_numeric($getPackageItem[0]['reserved_stock']) ? $getPackageItem[0]['reserved_stock'] : 0 ;

		$package_item_quantity = $_POST['package_item_quantity'];

		$usable_stock = $saga_quantity + $reserved_stock;


		if($package_item_quantity > $usable_stock) {
			echo json_encode(0);
		} else {

			$updatePackageItem = $QueryBuilder->update(
				$conn,
				$options = array(
					"table" => "package_items",
					"set" => ["`package_quantity`=".$package_item_quantity.""],
					"where" => "id = ".$_POST['package_item_id']
				)
			);

			echo json_encode($updatePackageItem);
		}

	

	$QueryBuilder->closeConnection();
?>