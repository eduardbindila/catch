<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

if ($_pageName == "catalog") {
	$category = "";
} else {
	$category = $_pageName;
}


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


$categoriesQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => 'categories' ,
			"columns" => "*",
			"where" => "parent_id = '".$category."'"
		)
	);




if($category) {
	echo 'a';
	$productsQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => 'products' ,
			"columns" => "id, product_image, product_name, initial_price as aquisition_price, ". $initial_price ."  as initial_price",
			"where" => "parent_id = '".$category."'"
		)
	);

	//var_dump($productsQuery);
}




include($_MPATH['CART_VIEWS'].'catalog_view.php');

?>