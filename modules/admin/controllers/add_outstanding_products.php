<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);

    // echo $vendorInvoiceId;

    // Construiește query-ul pentru insert multiplu
    $query = "INSERT INTO vendor_invoice_items (product_id, quantity, unit_price, total_price, vendor_invoice_id)
SELECT
    p.id AS product_id,
    p.saga_quantity AS quantity,
    0 AS unit_price,
    0 AS total_price,
    ".$_POST['vendor_invoice_id']." AS vendor_invoice_id
FROM
    products p
LEFT JOIN vendor_invoice_items vii ON
    p.id = vii.product_id AND vii.vendor_invoice_id = ".$_POST['vendor_invoice_id']."
WHERE
    vii.product_id IS NULL AND p.saga_quantity != 0; ";

    
   //echo $query;


    // Elimină virgula finală
    $query = rtrim($query, ',');

    //echo $query;

	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);

	
      //echo $conn->error;

echo  json_decode($projectsQuery);

	$QueryBuilder->closeConnection();


?>