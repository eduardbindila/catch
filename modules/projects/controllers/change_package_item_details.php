<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

	$updatePackageItem = $QueryBuilder->update(
				$conn,
				$options = array(
					"table" => "package_items",
					"set" => ["`item_details`='".$_POST['item_details']. "'"],
					"where" => "id = ".$_POST['package_item_id']
				)
			);

	echo json_encode($updatePackageItem);

	$QueryBuilder->closeConnection();
?>
