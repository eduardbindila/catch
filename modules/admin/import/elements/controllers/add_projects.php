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

$specifyerList = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => 'specifyer_designer',
		"columns" => "id, name"
	)
);

$projectStatusList = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => 'project_status',
		"columns" => "id, name"
	)
);

$quoteStatusList = $QueryBuilder->select(
	$conn,
	$options = array(
		"table" => 'quote_status',
		"columns" => "id, name"
	)
);


$i = 0;

$id = 1001;


//var_dump($usersList);

//similar_text($var_1, $var_2, $percent);


$projectArray = [];

$quoteArray = [];

while(! feof($f_pointer)){

	$project=fgetcsv($f_pointer);

	$legacy_id = $project[0];
	$parent_id = $project[1];
	$start_date = $project[2];
	$output_date = $project[3];
	$owner = $project[4];
	$project_name = $project[5];
	$client = $project[6];
	$lighting = $project[7];
	$specifyer = $project[8];
	$quote_status = $project[9];
	$quote_value = $project[10];
	$rev_value = $project[11];
	$winning = $project[12];
	$project_status = $project[13];
	$project_description = $project[14];

	if($start_date) {
		$start_date = date('Y-m-d', strtotime(str_replace('-', '/', $start_date)));
	}

	if($output_date) {
		$output_date = date('Y-m-d', strtotime(str_replace('-', '/', $start_date)));
	}

	$owner_id = getIDByName($owner, $usersList);

	$client_id = getIDByName($client, $clientsList);

	$specifyer_id = getIDByName($specifyer, $specifyerList);

	$quote_status_id = getIDByName($quote_status, $quoteStatusList);

	$quote_price = $quote_value ? $quote_value : $rev_value;

	$quote_price = is_numeric($quote_price) ? $quote_price : 0;

	$project_status_id = getIDByName($project_status, $projectStatusList);

	$duplicate = strtolower($legacy_id) == 'd' ? 1 : 0;

	$revision = $parent_id ? 1 : 0;

			$localProjectArray = array(
				'id' => $id,
				'legacy_id' => $legacy_id,
				'parent_id' => $parent_id,
				'owner_id' => $owner_id,
				'project_name' => $project_name,
				'project_status_id' => $project_status_id,
				'project_description' => $project_description,
				'master_quote' => $id,
				'revision' => $revision,
				'duplicate' => $duplicate,
				'locked' => 1
			);

			array_push($projectArray, $localProjectArray);



			$localQuoteArray = array(
				'id' => $id,
				'project_id' => $id,
				'start_date' => $start_date,
				'offer_date' => $output_date,
				'assignee_id' => $owner_id,
				'lighting_designer' => 1,
				'specifyer_designer' => $specifyer_id,
				'quote_status' => $quote_status_id,
				'quote_price' => $quote_price,
				'winning' => str_replace('%', '', $winning),
				'locked' => 1
			);

			array_push($quoteArray, $localQuoteArray);

	$id++;
	
}


 	$queryProjects = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "projects",
			"keys" => [
				'id',
				'legacy_id',
				'parent_id',
				'owner_id',
				'project_name',
				'project_status',
				'project_description',
				'master_quote',
				'revision',
				'duplicate',
				'locked'
		],
			"values" => $projectArray
		),
		$multi = true
	);

	$queryQuotes = $QueryBuilder->insert(
		$conn,
		$options = array(
			"table" => "quotes",
			"keys" => [
				'id',
				'project_id',
				'start_date',
				'offer_date',
				'assignee_id',
				'lighting_designer',
				'specifyer_designer',
				'quote_status',
				'quote_price',
				'winning_chance',
				'locked'
		],
			"values" => $quoteArray
		),
		$multi = true
	);


echo  json_decode($queryProjects);

	$QueryBuilder->closeConnection();

?>