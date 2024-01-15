<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);

 $dataArray = json_decode($_POST['data'], true);;
 // Obține datele postate de la client
     $vendorInvoiceId = $_POST["vendor_invoice_id"];

    // echo $vendorInvoiceId;

    // $dataArray conține datele parsate în PHP, poți face orice ai nevoie cu ele
    // De exemplu, le poți salva într-o bază de date


    // Construiește query-ul pentru insert multiplu
    $query = "INSERT INTO vendor_invoice_items (product_id, quantity, unit_price, total_price, vendor_invoice_id) VALUES ";

     foreach ($dataArray as $item) {
       $product_id = $conn->real_escape_string($item['product_id']);
       $quantity = $conn->real_escape_string($item['quantity']);
       $exists = $conn->real_escape_string($item['exists']);

       // Adaugă datele în query doar dacă exists este 1
       if ($exists == '1') {
           $unit_price = 0;  // Adaugă unit_price cu valoarea implicită 0
           $total_price = 0; // Adaugă total_price cu valoarea implicită 0
           $query .= "('$product_id', '$quantity', '$unit_price', '$total_price', '$vendorInvoiceId'),";
       }
   }

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