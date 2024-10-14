<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// printError($_POST);

if(empty($_POST['invoice_no'])) {
	$invoiceString = "`invoice_number`= NULL";
} else {
	$invoiceString = "`invoice_number`=".$_POST['invoice_no']."";
}

if(isset($_POST['exchange_rate_deviation'])) {
	$exchange_rate_deviation = $_POST['exchange_rate_deviation'];
} else {
	$exchange_rate_deviation = 0;
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
				"`other_details`='".addslashes(htmlspecialchars($_POST['other_details']))."'",
				"`exchange_rate_deviation`=".$exchange_rate_deviation."",
			],
			"where" => "id = ".$_POST['package_id']
		)
	);
//echo $conn->error;
	
	echo json_encode($updatePackageItem);
	

	$QueryBuilder->closeConnection();
?>