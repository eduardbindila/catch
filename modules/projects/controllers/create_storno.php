<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

	
$conn = $QueryBuilder->dbConnection();

$packageQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "packages",
			"columns" => "*",
			"where" => "id = '".$_POST['package']."'"
		)
	);


//print_R($_POST);


$packageQuery[0]['created_date'] = date("Y-m-d H:i:s");

$packageQuery[0]['package_status_id'] = 1;

$packageQuery[0]['isStorno'] = $_POST['package'] ;

unset($packageQuery[0]['id']);
unset($packageQuery[0]['pos_date']);
unset($packageQuery[0]['awb_date']);
unset($packageQuery[0]['invoice_number']);
unset($packageQuery[0]['invoice_date']);
unset($packageQuery[0]['invoice_due_date']);
unset($packageQuery[0]['other_details']);
unset($packageQuery[0]['is_unified_package']);
unset($packageQuery[0]['unified_package_id']);
unset($packageQuery[0]['original_package_id']);


$package_keys = array_keys($packageQuery[0]);

$package_values = array_values($packageQuery[0]);


$insertPackage = $QueryBuilder->insert(
    $conn,
    $options = array(
        "table" => "packages",
        "keys" => $package_keys,
        "values" => $package_values
    )

);



if($insertPackage) {
	$packageItemsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "package_items",
			"columns" => "*",
			"where" => "package_id = '".$_POST['package']."'"
		)
	);


	foreach ($packageItemsQuery as $key => $quoteItem) {

		unset($quoteItem['id']);
		unset($quoteItem['original_package_id']);

		$quoteItem['package_quantity'] = - $quoteItem['package_quantity'];

		$quoteItem['package_id'] = $insertPackage;

		if($quoteItem['external_item_unit_price'] == "")
		{
			unset($quoteItem['external_item_unit_price']);
		}

		if($quoteItem['quote_item_id'] == "")
		{
			unset($quoteItem['quote_item_id']);
		}

		$package_items_keys = array_keys($quoteItem);

		$package_items_values = array_values($quoteItem);
	
		//array_push($package_items_values, $quoteItem);

		$insertPackageItemsQuery = $QueryBuilder->insert(
	    $conn,
	    $options = array(
	        "table" => "package_items",
	        "keys" => $package_items_keys,
	        "values" => $package_items_values
	    )
	);
	}
	
}


// print_r($conn);

	echo $conn->error;

// printError($package_items_keys);
// printError($package_items_values);

echo json_encode($package_values);



	$QueryBuilder->closeConnection();


?>