<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');





$conn = $QueryBuilder->dbConnection();


	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "packages",
			"keys" => ["quote_id", "is_unified_package","package_status_id"],
			"values" => [$_POST['quoteId'], 1, 3]
		)
	);

	if($query) {

		$packageArray = $_POST['packageArray'];
		$packageString = implode(',', $packageArray);

		$updatePackages = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "packages",
				"set" => ["`unified_package_id`='".$query."'"],
				"where" => "id in (".$packageString.")"
			)
		);

		$updatePackageItems = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "package_items",
				"set" => ["`package_id`='".$query."'"],
				"where" => "package_id in (".$packageString.")"
			)
		);
	}

//printError($_POST);
 		echo$conn->error;


	echo  json_decode($query);

	$QueryBuilder->closeConnection();
?>