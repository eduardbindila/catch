<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$makeInventory = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "vendor_invoices",
			"set" => ["`inventory`=".$_POST['inventory']."",],
			"where" => "id = ".$_POST['vendor_invoice_id']
		)
	);


	echo json_encode($makeInventory);

	$QueryBuilder->closeConnection();
?>
