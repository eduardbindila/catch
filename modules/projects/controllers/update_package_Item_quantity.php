<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);



		$getPackageItem = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quote_items",
				"columns" => "products.saga_quantity, quote_items.reserved_stock, quote_items.product_id, quote_items. id as quote_item_id",
				"innerJoin" => 'products on quote_items.product_id = products.id',
				"where" => "quote_items.id = '".$_POST['quote_item_id']."'"
			)
		);

		$saga_quantity = is_numeric($getPackageItem[0]['saga_quantity']) ? $getPackageItem[0]['saga_quantity'] : 0 ;

		$reserved_stock = is_numeric($getPackageItem[0]['reserved_stock']) ? $getPackageItem[0]['reserved_stock'] : 0 ;

		$package_item_quantity = $_POST['package_item_quantity'];

		$product_id = $_POST['product_id'];

		$quote_item_id = $_POST['quote_item_id'];

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

			if(($package_item_quantity > $reserved_stock) && $updatePackageItem) {

				$product_stock = $GetDetails->productStock($product_id);

				$reserved_stock = $GetDetails->reservedStock($quote_item_id);

				$quantity_dif = $package_item_quantity - $reserved_stock;

				$new_reserved_stock = $reserved_stock + $quantity_dif;

				$new_product_stock = $product_stock - $quantity_dif;

				$updateQuoteItem = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "quote_items",
						"set" => ["`reserved_stock`='".$new_reserved_stock."'"],
						"where" => "id = '".$quote_item_id."'"
					)
				);



				if($updateQuoteItem) {
					$updateProducts = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "products",
						"set" => ["`saga_quantity`='".$new_product_stock."'"],
						"where" => "id = '".$product_id."'"
					)
				);
				}
			}

			echo json_encode($updatePackageItem);
		}

	

	$QueryBuilder->closeConnection();
?>