<?php

// At start of script
// $time_start = microtime(true); 



require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// $_POST['import_product_list_id'] = 3;

$date = date('Y-m-d H:i:s');



$getLatestListId = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "import_product_list",
			"columns" => "max(id) as latest_list_id"
		)
	);



$updateListsQuery = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => "products_import",
		"columns" => "*",
		"where" => "import_product_list_id=".$getLatestListId[0]['latest_list_id']." and status in  (7, 2)",
		"limit" => "100"
	)
);

var_dump($updateListsQuery);

foreach ($updateListsQuery as $product => $product_details) {

	// var_dump("<pre>");
	// var_dump($product_details);
	// var_dump("</pre>"); 

	$oldPrice = 0;
	$comment = null;



	$thisProductQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "id",
			"where" => "id='".$product_details['product_id']."'"
		),
			$returnType = "bol"
	);


	$legacyProductQuery =  $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "id",
			"where" => "id='".$product_details['new_product_id']."'"
		),
			$returnType = "bol"
	);


	// var_dump("<pre>");
	// var_dump($thisProductQuery);
	// var_dump("</pre>");

	if($legacyProductQuery) {

		$updateQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "products",
				"set" => ["`merged_id`='".$product_details['product_id']."'", "`merge_status`=2"],
				"where" => "id = '".$product_details['new_product_id']."'"
			)
		);

		if($updateQuery) {
			$updateStatus = 9; //Succesfully Updated
			
			$comment = 'Product needs merge';
		} else {
			$updateStatus = 2; //Error
			$comment = addslashes($conn->error);
		}

	} else if($thisProductQuery) {
		$updateQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "products",
				"set" => ["`id`='".$product_details['new_product_id']."'", "`legacy_id`='".$product_details['product_id']."'"],
				"where" => "id = '".$product_details['product_id']."'"
			)
		);

		if($updateQuery) {
			$updateStatus = 8; //Succesfully Updated
			
		} else {
			$updateStatus = 2; //Error
			$comment = addslashes($conn->error);
		}

		//var_dump($comment);

		//var_dump($conn-> error);
	} 
	else {
		$updateStatus = 2;
		$comment = 'Product not found';
	}


	$updateImportProductQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products_import",
			"set" => [ "`status`='".$updateStatus."'", "`comment`='".$comment."'", "`date`='".$date."'", "`user_id`='".$_SESSION['user_id']."'"],
			"where" => "id = '".$product_details['id']."'"
		)
	);


}

// Anywhere else in the script
// echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);

?>