<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

$exchange_rate = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	//printError($_POST);

	$conn = $QueryBuilder->dbConnection();

	if(is_numeric($userId)) {
		$query = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "vendor_invoices",
				"set" => [
					"`invoice_no`='".$_POST['invoice_no']."'",
					"`vendor`='".$_POST['vendor']."'",
					"`date`='".$_POST['date']."'",
					"`due_date`='".$_POST['due_date']."'",
					"`currency`='".$_POST['currency']."'",
					"`exchange_rate`='".$_POST['exchange_rate']."'",
					"`vat_value`='".$_POST['vat_value']."'",
					"`invoice_value`='".$_POST['invoice_value']."'"
					],
				"where" => "id =".$userId
			)
		);

		echo $conn->error;
	} else {
		$query = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "vendor_invoices",
				"keys" => ["invoice_no", "vendor", "date", "due_date", "currency", "exchange_rate", "vat_value", "invoice_value"],
				"values" => [$_POST["invoice_no"], $_POST["vendor"], $_POST["date"], $_POST["due_date"], $_POST["currency"], $_POST["exchange_rate"],$_POST["vat_value"], $_POST["invoice_value"]]
			),
			$multi = false
		);

		echo $conn->error;
	}

	$insertResult = json_decode($query);

	if($insertResult > 0) {
		$insertResult = $insertResult;
	} else {
		$insertResult = 0;
	}

	$QueryBuilder->closeConnection();
}

if(is_numeric($userId)) {

	$conn = $QueryBuilder->dbConnection();

	$invoiceQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "vendor_invoices",
			"columns" => "vendor_invoices.*, vendors.code as saga_code",
			"innerJoin" => "vendors on vendor_invoices.vendor = vendors.id",
			"where" => 'vendor_invoices.id = '.$userId
		)
	);

	$invoiceGET = [
		"typeNo"=>"4",
		"typeName"=>"intrari",
		"invoice"=>$invoiceQuery[0]['invoice_no'],
		"code"=>$invoiceQuery[0]['saga_code']
	];

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'vendor_invoice_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'vendor_invoices_view.php');
}
	
?>