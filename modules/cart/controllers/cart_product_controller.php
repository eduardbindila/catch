<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


if(isset($_GET['temp'])) {
	$table = "products_temp";
	$is_temporary = 1;
} else {
	$table = "products";
	$is_temporary = 0;
}

$productID =  urldecode($_GET['id']);

$conn = $QueryBuilder->dbConnection();

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

	$query = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "products",
			"set" => [
				"`product_name`='".$_POST['product_name']."'",
				"`product_description`='". htmlspecialchars($_POST['product_description'])."'",
				"`initial_price`='".$_POST['initial_price']."'",
				"`saga_quantity`='".$_POST['stock']."'",
				],
			"where" => "id ='".$productID."'"
		)
	);
	
}


	$productQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => 'products' ,
			"columns" => "*",
			"where" => "id = '".$productID."'"
		)
	);


	$productName = $productQuery[0]['product_name'];
	$aquisitionPrice = $productQuery[0]['initial_price'];
	$stock = $productQuery[0]['saga_quantity'];

	if($_SESSION['client_discount'] > 0) {
		$productPrice = $aquisitionPrice / $Pricing->listPercent ."* ". $_SESSION['client_discount']. " /100"; 
	} else {
		$productPrice = $aquisitionPrice / $Pricing->listPercent;
	}
	
	$productImage = $productQuery[0]['product_image'];
	$productDescription = htmlspecialchars_decode($productQuery[0]['product_description']);

	if(!$productImage) {
		$productImage = "http://ideyafoana.com/api/public/storage/photo/no-image.png";
	}
	

	if(isset($_GET['temp'])) {
		$productParentID = "---";
		$productDiagrams = "";
		$productFeaturesQuery = "";
		
	} else {
		$productParentID = $productQuery[0]['parent_id'];
		$productDiagrams = htmlspecialchars_decode($productQuery[0]['product_diagrams']);
		$productFeaturesQuery = $QueryBuilder->selectFeatures($conn, $productID);
	}


	$QueryBuilder->closeConnection();



include($_MPATH['CART_VIEWS'].'cart_product_view.php');

?>