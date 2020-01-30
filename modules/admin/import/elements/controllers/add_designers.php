<?php

require_once('../../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer

$when = '';

$ids = '';

$i = 0;


$valuesArray = [];

while(! feof($f_pointer)){

	$user=fgetcsv($f_pointer);

	

	$user_name = $user[0];

	if($user_name) {
		

		$localArray = array(
			'name' => $user_name
		);

		array_push($valuesArray, $localArray);


	}
	
}


$conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "specifyer_designer",
			"keys" => ["name"],
			"values" => $valuesArray
		),
		$multi = true
	);


echo  json_decode($query);

	$QueryBuilder->closeConnection();

?>