<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//printError($_POST);

if(isset($_POST['invoice_no'])) {
	$invoiceString = "`invoice_number`=".$_POST['invoice_no']."";
} else {
	$invoiceString = "`invoice_number`= NULL";
}

	$updatePackageItem = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "packages",
			"set" => [
				$invoiceString,
				"`invoice_date`='".$_POST['date']."'",
				"`invoice_due_date`='".$_POST['due_date']."'",
				"`exchange_rate`=".$_POST['exchange_rate']."",
				"`other_details`='".addslashes(htmlspecialchars($_POST['other_details']))."'"
			],
			"where" => "id = ".$_POST['package_id']
		)
	);
//echo $conn->error;
	
	echo json_encode($updatePackageItem);
	

	$QueryBuilder->closeConnection();
?>