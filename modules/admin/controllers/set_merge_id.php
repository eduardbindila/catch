<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

	$productsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "id",
			"where" => "merged_id is null",
			"limit" => "100"
		),
		$returnType = "idAsArray"
	);

	foreach ($productsQuery as $product => $product_details) {

		//echo "<pre>";

		$merge_id = 0;
		$merge_status = NULL;
		
		 if(is_numeric($product)){
		 	//echo "is numeric";
		 	$processedProduct = $product;
		 	$processedProduct += 0;
		 	
		 } else {
		 	//echo "is not numeric";
		 	$processedProduct = preg_replace("/[^a-zA-Z 0-9]+/", "",  trim($product));
		 }


		if($product !== $processedProduct && isset($productsQuery[$processedProduct])) {
			
			$merge_id = $processedProduct;
			$merge_status = 2;	
		}
		else {
			$merge_status = 1;
		}

		// echo $product.' => '.$merge_id.' : '.$merge_status;
		// echo "</pre>";
		
		$updateMergeDataProductQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "products",
				"set" => ["`merged_id`='".$merge_id."'","`merge_status`='".$merge_status."'",],
				"where" => "id = '".$product."'"
			)
		);
	}

$QueryBuilder->closeConnection();

?>