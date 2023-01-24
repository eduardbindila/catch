<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump($_POST);   


if ($_POST['country'] == "RO") 
{
	$operator = "=";
} else {
	$operator = "!=";
}

	$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "packages",
				"columns" => "MAX(packages.invoice_number) as max",
				"innerJoin" => 'quotes on packages.quote_id = quotes.id 
								join clients on quotes.client_id  = clients.id',
				"where" => "clients.country ".$operator." 'RO' and packages.package_status_id = 4 ",
				"orderBy" => 'packages.id',
				"orderType" => 'DESC'
			)
		);

	$newInvoiceNumber = (float)$query[0]['max'] + 1;

	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "packages",
			"set" => ["`invoice_number`=".$newInvoiceNumber],
			"where" => "id = ".$_POST['packageId']
		)
	);

	if($projectsQuery) {
		echo json_encode($newInvoiceNumber);
	}
	else {
		echo false;
	}


	

	$QueryBuilder->closeConnection();
?>