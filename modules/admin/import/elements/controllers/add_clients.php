<?php

require_once('../../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

$f_pointer=fopen($target_dir.$_POST["file_name"],"r"); // file pointer


 $conn = $QueryBuilder->dbConnection();

$usersList = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => 'users',
		"columns" => "id, name"
	)
);

$clientsList = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => 'clients',
		"columns" => "id, name"
	)
);

$i = 0;


//var_dump($usersList);

//similar_text($var_1, $var_2, $percent);


$valuesArray = [];

while(! feof($f_pointer)){

	$clients=fgetcsv($f_pointer);

	$name =$clients[1];

	$fiscal = $clients[2];

	$country = $clients[4];

	$state = $clients[5];

	$address = $clients[6];

	$bank_account = $clients[7];

	$bank = $clients[8];

	$phone = $clients[9];

	$email = $clients[10];

	$registry = $clients[12];

	$agent = $clients[18];

	$agent_id = getIDByName($agent, $usersList);

			$localArray = array(
				'name' => $name,
				'fiscal_code' => $fiscal,
				'country' => $country,
				'state' => $state,
				'address' => $address,
				'bank_account' => $bank_account,
				'bank' => $bank,
				'phone' => $phone,
				'email' => $email,
				'registry' => $registry,
				'user_id' => $agent_id,
			);

			array_push($valuesArray, $localArray);
	
}

// var_dump($valuesArray);

 	$query = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "clients",
			"keys" => ['name',
			'fiscal_code' ,
			'country',
			'state',
			'address',
			'bank_account',
			'bank',
			'phone',
			'email',
			'registry',
			'user_id',
		],
			"values" => $valuesArray
		),
		$multi = true
	);


echo  json_decode($query);

	$QueryBuilder->closeConnection();

?>