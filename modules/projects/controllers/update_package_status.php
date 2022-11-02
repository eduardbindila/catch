<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

	$updatePackageItem = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "packages",
			"set" => ["`package_status_id`=".$_POST['nextStatus'].""],
			"where" => "id = ".$_POST['packageId']
		)
	);

	if($_POST['nextStatus'] == 4) {
		$packageItems = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "package_items",
			"columns" => "*",
			"where" => "package_id = ".$_POST['packageId']
		));

		if($packageItems) {
			foreach ($packageItems as $key => $quoteItem) {

				//printError($quoteItem);

				$updateQuoteItems = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "quote_items",
						"set" => [
							"`reserved_stock`= reserved_stock - ".$quoteItem['package_quantity']."",
							"`invoiced_quantity`=  invoiced_quantity + ".$quoteItem['package_quantity'].""],
						"where" => "`id` = ".$quoteItem['quote_item_id'].";"
					)
				);

			}
			echo json_encode($updateQuoteItems);
		}
	} else {
		echo json_encode($updatePackageItem);
	}



		

	$QueryBuilder->closeConnection();
?>