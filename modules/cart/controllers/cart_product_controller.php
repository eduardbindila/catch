<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$productID = basename($actual_link);


$conn = $QueryBuilder->dbConnection();

	$productQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "products",
			"columns" => "*",
			"where" => "id = '".$productID."'"
		)
	);

	$productName = $productQuery[0]['product_name'];
	$productParentID = $productQuery[0]['parent_id'];
	$productImage = $productQuery[0]['product_image'];
	$productDescription = htmlspecialchars_decode($productQuery[0]['product_description']);
	$productDiagrams = htmlspecialchars_decode($productQuery[0]['product_diagrams']);

	$productFeaturesQuery = $QueryBuilder->selectFeatures($conn, $productID);

	$QueryBuilder->closeConnection();




include($_MPATH['CART_VIEWS'].'cart_product_view.php');

?>