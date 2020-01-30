<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$category = $_POST['category'];

$conn = $QueryBuilder->dbConnection();

$query = $QueryBuilder->insert(
	$conn,
	$options = array(
		"table" => "categories",
		"keys" => ["id", "category_name", "category_image", "parent_id"],
		"values" => [$category["category_slug"], $category["category_name"], $category["category_image"], $category["parent_slug"]]
	)
);


$QueryBuilder->closeConnection();

?>