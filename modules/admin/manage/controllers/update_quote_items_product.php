<?php

// At start of script
// $time_start = microtime(true); 



require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// $_POST['import_product_list_id'] = 3;

//$date = date('Y-m-d H:i:s');




	$updateQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quote_items",
				"set" => ["`product_id`='".$_POST['updated_product_id']."'"],
				"where" => "product_id = '".$_POST['product_id']."'"
			)
		);



// Anywhere else in the script
// echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);

?>