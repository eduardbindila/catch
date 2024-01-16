<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
	
$conn = $QueryBuilder->dbConnection();


//printError($_POST);


    // Construiește query-ul pentru insert multiplu
    $pquery = "UPDATE products p SET p.saga_quantity = 0;";

    $qiquery = "UPDATE quote_items qi SET qi.reserved_stock = 0;";

    
   //echo $query;


	$productsQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $pquery
	);

	$quotesQuery = $QueryBuilder->customQuery(
		$conn,
		$query = $qiquery
	);


if($productsQuery && $quotesQuery)
	echo  1;
	else
	echo 0;



	$QueryBuilder->closeConnection();


?>