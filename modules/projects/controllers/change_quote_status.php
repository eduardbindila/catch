<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$quoteStatuses =  $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "quote_status",
			"columns" => "*"
		),
		$returnType = 'idAsArray'
	);

	$quoteStatusAvailableSteps = array(
		'4' => array(
			'next'=> '3',
			'profit-low'=> '7'
		),
		'3' => array(
			'next'=> '1'
		),
		'1' => array(
			'next'=> '5'
		),
		'5' => array(
			'next'=> '2'
		),
		'7' => array(
			'next'=> '4',
		),
		'2' => array(
			'next'=> '2'
		),
	);

	$other = '';

	if($_POST['quote_status'] == 4 && isset($_POST['profit_low']) && $_POST['profit_low']) {

		if($_POST['afterApprove'] == 1) {
			$new_status = $quoteStatusAvailableSteps[$_POST['quote_status']]['next'];
		} else {
			$new_status = $quoteStatusAvailableSteps[$_POST['quote_status']]['profit-low'];
		}

		
	}
	else {

		$new_status = $quoteStatusAvailableSteps[$_POST['quote_status']]['next'];
	}

	if($new_status == 3) {
		$offer_date = ", offer_date='".date("Y-m-d")."'";
	}
	else {
		$offer_date = '';
	}

	if(($_POST['quote_status'] == 7) && isset($_POST['jump_status']) && ($_POST['jump_status'] != 3)) {
		$afterApprove = 1;
		$other = ', `afterApprove`=1';
	} else {
		$afterApprove = 0;
	}

	if(isset($_POST['jump_status'])) {
		$new_status = $_POST['jump_status'];
	}

	//echo $new_status;


	$projectsQuery = $QueryBuilder->update(
		$conn,
		$options = array(
			"table" => "quotes",
			"set" => ["`quote_status`=".$new_status.$offer_date.$other],
			"where" => "id = ".$_POST['quote_id']
		)
	);

	if($projectsQuery) {
		echo json_encode($new_status);
	} else {
		echo json_encode($projectsQuery);
	}


	

	$QueryBuilder->closeConnection();


?>