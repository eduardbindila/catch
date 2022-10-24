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

		echo json_encode($updatePackageItem);

	$QueryBuilder->closeConnection();
?>