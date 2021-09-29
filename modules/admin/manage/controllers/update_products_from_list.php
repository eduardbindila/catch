<?php

// At start of script
// $time_start = microtime(true); 



require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// $_POST['import_product_list_id'] = 3;

$date = date('Y-m-d H:i:s');


$updateListsQuery = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => "products_import",
		"columns" => "*",
		"where" => "import_product_list_id=".$_POST['import_product_list_id']." and status = 1",
		"limit" => "100"
	)
);

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
			"columns" => "id, initial_price",
			"where" => "id='".$product_details['product_id']."'"
		)
	);

	// var_dump("<pre>");
	// var_dump($thisProductQuery);
	// var_dump("</pre>");

	if($thisProductQuery) {
		$updateQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "products",
				"set" => ["`initial_price`='".$product_details['price']."'", "`product_name`='".$product_details['name']."'", "`imported_list_id`='".$_POST['import_product_list_id']."'", "`last_updated_date`='".$date."'"],
				"where" => "id = '".$product_details['product_id']."'"
			)
		);

		if($updateQuery) {
			$updateStatus = 5; //Succesfully Updated
			$oldPrice = $thisProductQuery[0]['initial_price'];
		} else {
			$updateStatus = 2; //Error
			$comment = addslashes($conn->error);
		}

		//var_dump($comment);

		//var_dump($conn-> error);
	} else {

		$insertQuery = $QueryBuilder->insert(
			$conn,
			$options = array(
				"table" => "products",
				"keys" => ["id", "product_name", "initial_price", "manufacturer", "added_date", "imported_list_id", "last_updated_date"],
				"values" => [$product_details['product_id'], $product_details['name'], $product_details['price'], $product_details['manufacturer'], $date ,$_POST['import_product_list_id'], $date]
			)
		);

		if($insertQuery) {
			$updateStatus = 6; //New Product Added
		} else {
			$updateStatus = 2; //Error
			$comment = addslashes($conn->error);
		}

	}


	$updateImportProductQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products_import",
			"set" => ["`old_price`='".$oldPrice."'", "`status`='".$updateStatus."'", "`comment`='".$comment."'", "`date`='".$date."'", "`user_id`='".$_SESSION['user_id']."'"],
			"where" => "id = '".$product_details['id']."'"
		)
	);


}

// Anywhere else in the script
// echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);


// $query = $QueryBuilder->insert(
// 	$conn,
// 	$options = array(
// 		"table" => "import_product_list",
// 		"keys" => ["name", "file_url", "date_uploaded", "user_id"],
// 		"values" => [$import_name, $import_file, strtotime("now"), $_SESSION['user_id']]
// 	)
// );


// echo json_decode($query);

//var_dump($_POST);

?>