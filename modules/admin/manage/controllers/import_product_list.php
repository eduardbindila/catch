<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$import_name = $_POST['name'];
$import_file = $_POST['file_name'];

$conn = $QueryBuilder->dbConnection();



$query = $QueryBuilder->insert(
	$conn,
	$options = array(
		"table" => "import_product_list",
		"keys" => ["name", "file_url", "date_uploaded", "user_id"],
		"values" => [$import_name, $import_file, strtotime("now"), $_SESSION['user_id']]
	)
);


echo json_decode($query);

//var_dump($_POST);

?>