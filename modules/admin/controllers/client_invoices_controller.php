<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$insertResult = 'undefined';

$exchange_rate = '';

if(is_numeric($userId)) {

	$conn = $QueryBuilder->dbConnection();

	$query = "select p.id, p.isStorno, p.other_details, p.exchange_rate, quote_id, invoice_number, invoice_date, invoice_due_date, c.name, c.saga_code, c.country  from packages p
join quotes q on q.id = p.quote_id 
join clients c on c.id = q.client_id
where p.id = ".$userId."
order by id desc";



	 // Use your custom query builder to execute the query
    $invoiceQuery = $QueryBuilder->customQuery(
        $conn,
        $query
    );


// printError($invoiceQuery);

 $packageID = $invoiceQuery[0]['id'];

$_POST['packageId'] = $packageID;

$_POST['isStorno'] = $invoiceQuery[0]['isStorno'];

 $invoiceData = array(
        "invoiceDate" => $invoiceQuery[0]['invoice_date'],
        "dueDate" => $invoiceQuery[0]['invoice_due_date'],
        "exchangeRate" => $invoiceQuery[0]['exchange_rate'],
        "invoiceNumber" => $invoiceQuery[0]['invoice_number'],
        "packageId" => $_POST['packageId'],
        "otherDetails" =>  $invoiceQuery[0]['other_details']
    );

$invoiceNumber = ($invoiceQuery[0]['country'] == "RO" ? 'RON-' : 'EXT-').$invoiceQuery[0]['invoice_number'];

	$invoiceGET = [
		"typeNo"=>"4",
		"typeName"=>"iesiri",
		"invoice"=>$invoiceNumber,
		"code"=>$invoiceQuery[0]['saga_code']
	];

	//printError($invoiceGET);

	$QueryBuilder->closeConnection();

	include($_MPATH['ADMIN_VIEWS'].'client_invoice_view.php');
} else {
	include($_MPATH['ADMIN_VIEWS'].'client_invoices_view.php');
}
	
?>