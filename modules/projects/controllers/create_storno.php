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


$packageQuery[0]['created_date'] = date("Y-m-d H:i:s");

$packageQuery[0]['package_status_id'] = 1;

unset($packageQuery[0]['id']);
unset($packageQuery[0]['pos_date']);
unset($packageQuery[0]['awb_date']);
unset($packageQuery[0]['invoice_number']);
unset($packageQuery[0]['invoice_date']);
unset($packageQuery[0]['invoice_due_date']);
unset($packageQuery[0]['other_details']);


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


	unset($packageItemsQuery[0]['id']);

	$package_items_keys = array_keys($packageItemsQuery[0]);

	$package_items_values = array();

	foreach ($packageItemsQuery as $key => $quoteItem) {


		$quoteItem['package_quantity'] = - $quoteItem['package_quantity'];

		$quoteItem['package_id'] = $insertPackage;

		$quoteItem['external_item_unit_price'] = $quoteItem['external_item_unit_price'] == "" ? 0 : $quoteItem['external_item_unit_price'] ;
	
		array_push($package_items_values, $quoteItem);

	}


	$insertPackageItemsQuery = $QueryBuilder->insert(
    $conn,
    $options = array(
        "table" => "package_items",
        "keys" => $package_items_keys,
        "values" => $package_items_values
    ),
    $multi = true
);
}




	echo $conn->error;

echo json_encode($insertPackageItemsQuery);

	$QueryBuilder->closeConnection();


?>