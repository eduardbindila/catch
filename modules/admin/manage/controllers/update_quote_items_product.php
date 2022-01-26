<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$conn = $QueryBuilder->dbConnection();

$date = date('Y-m-d H:i:s');

$_POST['type'] = 'legacy';

if($_POST['type'] == "merge"){
	$field = "merged_id";
	$where = "p.merged_id != 0 and merge_status = 2";

} else if($_POST['type'] = "legacy") {

	$field = "legacy_id";
	$where = "p.legacy_id is not null and p.id != legacy_id";
}

$affectedQuoteItems = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products as p",
			"columns" => "p.id as product_id, p.merged_id, legacy_id",
			"innerJoin" => "quote_items as qim on p.".$field." = qim.product_id",
			"where" => $where,
			"limit" => 10,
			"columnAsArray" => "product_id"
		),
		$returnType = "columnAsArray"
	);


foreach ($affectedQuoteItems as $product => $productDetails) {

	//var_dump($productDetails);

	$updateQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "quote_items",
				"set" => ["`product_id`='".$productDetails['product_id']."'"],
				"where" => "product_id = '".$productDetails[$field]."'"
			)
		);

	if($updateQuery) {
		$status = 4;
		//$comment = "Quotes Modified"
	}
	else {
		$status = 5;
		//$comment = addslashes($conn->error);
	}

	$updateMergeDataProductQuery = $QueryBuilder->update(
			$conn,
			$options = array(
				"table" => "products",
				"set" => ["`merge_status`='4'", "`merged_date`='".$date."'",],
				"where" => "id = '".$productDetails['product_id']."'"
			)
		);
}


//var_dump($conn->error);





	


echo json_encode($affectedQuoteItems);

?>