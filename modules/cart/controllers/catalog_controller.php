<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

if ($_pageName == "catalog") {
	$category = "";
} else {
	$category = $_pageName;
}

//echo 'asd'.$category;

$categoriesQuery = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => 'categories' ,
			"columns" => "*",
			"where" => "parent_id = '".$category."'"
		)
	);

//var_dump($categoriesQuery);

include($_MPATH['CART_VIEWS'].'catalog_view.php');

?>