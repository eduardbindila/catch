<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);


if($_POST['nextStatus'] == 2) {
	$set = ["`package_status_id`=".$_POST['nextStatus']."", "`pos_date`=COALESCE(pos_date, NOW())"];
} else if ($_POST['nextStatus'] == 3) {
	$set = ["`package_status_id`=".$_POST['nextStatus']."", "`awb_date`=COALESCE(awb_date, NOW())"];
} else {
	$set = ["`package_status_id`=".$_POST['nextStatus'].""];
}

	$updatePackageItem = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "packages",
			"set" => $set,
			"where" => "id = ".$_POST['packageId']
		)
	);

	echo $conn->error;

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