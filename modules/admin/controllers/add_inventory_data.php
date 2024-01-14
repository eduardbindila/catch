<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);

 $dataArray = $_POST["data"];
     $vendorInvoiceId = $_POST["vendor_invoice_id"];

    // $dataArray conține datele parsate în PHP, poți face orice ai nevoie cu ele
    // De exemplu, le poți salva într-o bază de date


    // Construiește query-ul pentru insert multiplu
    $query = "INSERT INTO vendor_invoice_items (product_id, quantity, unit_price, total_price, vendor_invoice_id) VALUES ";

     foreach ($dataArray as $item) {
        $product_id = $conn->real_escape_string($item['product_id']);
        $quantity = $conn->real_escape_string($item['quantity']);
        $unit_price = 0;  // Adaugă unit_price cu valoarea implicită 0
        $total_price = 0; // Adaugă total_price cu valoarea implicită 0
        $query .= "('$product_id', '$quantity', '$unit_price', '$total_price', '$vendorInvoiceId'),";
    }

    // Elimină virgula finală
    $query = rtrim($query, ',');

    // Elimină virgula finală
    $query = rtrim($query, ',');


    echo $query;

// $query = '
// UPDATE products p
// JOIN vendor_invoice_items vii ON vii.product_id = p.id
// JOIN vendor_invoices vi ON vii.vendor_invoice_id = vi.id
// SET
//   vii.delivered_quantity = vii.quantity - p.saga_quantity,
//   p.saga_quantity = vii.quantity,
//   vi.closed_invoice = 1,
//   vi.closed_date = NOW()
// WHERE
//   vi.id = '.$_POST['vendor_invoice_id'].';
// ';

	$projectsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $query
	);

	echo $conn->error;

echo  json_decode($projectsQuery);

	$QueryBuilder->closeConnection();


?>