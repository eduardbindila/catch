<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

//var_dump(json_decode($_POST['wishlist']));

$idList = '"' . implode('", "', json_decode($_POST['wishlist'])) . '"';

//var_dump($idList);


if(isset($_SESSION['is_client']) && $_SESSION['is_client'] && $_SESSION['user_type'] == 3) {
	if($_SESSION['client_discount'] > 0) {
		$initial_price = "initial_price/". $Pricing->listPercent ."* ". $_SESSION['client_discount']. " /100"; 
	} else {
		$initial_price = "initial_price/". $Pricing->listPercent;
	}
} else {
	//$initial_price = "initial_price";

	$initial_price = "initial_price/". $Pricing->listPercent;
}



	$wishlistProducts = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "id, product_image, product_name, initial_price as aquisition_price, ". $initial_price ."  as initial_price",
			"where" => "id in (".$idList.")"
		),
		$returnType = 'idAsArray'
	);

	echo json_encode($wishlistProducts);

	$QueryBuilder->closeConnection();

?>