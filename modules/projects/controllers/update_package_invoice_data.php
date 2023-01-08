<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

	$updatePackageItem = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "packages",
			"set" => [
				"`invoice_number`=".$_POST['invoice_no']."",
				"`invoice_date`='".$_POST['date']."'",
				"`invoice_due_date`='".$_POST['due_date']."'",
				"`exchange_rate`=".$_POST['exchange_rate']."",
				"`other_details`='".addslashes(htmlspecialchars($_POST['other_details']))."'"
			],
			"where" => "id = ".$_POST['package_id']
		)
	);

	
	echo json_encode($updatePackageItem);
	

	$QueryBuilder->closeConnection();
?>