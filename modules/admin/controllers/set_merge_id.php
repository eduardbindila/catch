<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$productsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "id"
		),
		$returnType = "idAsArray"
	);

	foreach ($productsQuery as $product => $product_details) {

		$merge_id = null;
		$merge_status = null;
		
		 if(is_numeric($product)){
		 	$processedProduct = $product;
		 	$processedProduct += 0;
		 	
		 } else {
		 	$processedProduct = preg_replace("/[^a-zA-Z 0-9]+/", "",  trim($product));
		 }


		if($product !== $processedProduct && isset($productsQuery[$processedProduct])) {
			var_dump("<pre>");
			var_dump($processedProduct);
			var_dump("</pre>");
			$merge_id = $processedProduct;
			$merge_status = 2;	
		}
		else {
			$merge_status = 1;
		}

		 
	}

$QueryBuilder->closeConnection();

?>