<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


function getExchangeRateByDate($year, $date)
{
	$url = "https://www.bnr.ro/files/xml/years/nbrfxrates".$year.".xml";

	//echo $url;

	$xml = simplexml_load_file($url);

	$currency = [];


	$exchange_rate = 0;

	foreach($xml->Body->Cube as $cube) {

		$cubeDateXML_dt = new DateTime($cube['date']);


		if($cubeDateXML_dt == $date) {

			//echo $cubeDateXML_dt.' si '.$cubeDate_dt; 

			foreach($cube->children() as $line)    
	    	{  
	    		//printError($line); 

	    		if($line["currency"] == 'EUR') {
	    			$exchange_rate = $line;
	    			$currency[]=array("name"=>$line["currency"], "value"=>$line, "multiplier"=>$line["multiplier"]);
	    		}

	        	
	    	}
		}
		//print_R($currency);

		
	}

	return $exchange_rate;

}




	$date = $_POST['date'];

	$dateObj = date_parse_from_format("d/m/Y", $date);


	

	if($dateObj['error_count'] > 0) {
		$dateObj = date_parse_from_format("Y-m-d", $date);
	}

	



	$cubeDate = date("Y-m-d", strtotime($date));

	// returns original date string assuming the format was Y-m-d H:i:s
	$cubeDate = date('Y-m-d ', mktime($dateObj['hour'], $dateObj['minute'], $dateObj['second'], $dateObj['month'], $dateObj['day'], $dateObj['year'])); 

	$cubeDate_dt = new DateTime($cubeDate);

	$cubeDate_dt = $cubeDate_dt->modify('-1 day');

	

	$exchange_rate = 0;

	$exchange_rate = getExchangeRateByDate($cubeDate_dt->format("Y"), $cubeDate_dt);


	//print_r($exchange_rate);

	$iterator = 0;


	while ($exchange_rate == 0) {

		$iterator ++;

		$exchange_rate = getExchangeRateByDate($cubeDate_dt->format("Y"), $cubeDate_dt);

		$cubeDate_dt = $cubeDate_dt->modify('-1 day');

		//print_r($exchange_rate);

		if ($iterator > 5) {
			break;
		}
	}

	//print_r($currency[0]['value']);

	echo json_encode($exchange_rate);
?>