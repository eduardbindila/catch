<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_POST);

$isBulkSearch = isset($_POST['searchBulk']) && $_POST['searchBulk'] != "";

	$dummyArray = array();
	$foundArray = array();

	

		if($isBulkSearch) {

			$rawBulkArray = explode("\r\n", $_POST['searchBulk']);

			foreach($rawBulkArray as $key=>$val)
			{ 
			     $dummyArray[$key]["id"] = $val;
			     $dummyArray[$key]["product_name"] = "";
			     $dummyArray[$key]["initial_price"] = 0.00;
			     $dummyArray[$key]["from_db"] = 0;
			}  

			$idList = '"' . implode('", "', $rawBulkArray) . '"';;

			$whereClause = "id IN (".$idList.") ORDER BY FIELD(id,".$idList.");";
		

			if(isset($_SESSION['is_client']) && $_SESSION['is_client'] && $_SESSION['user_type'] == 3) {
				$initial_price = "initial_price/". $Pricing->listPercent ."* ". $_SESSION['client_discount']. " /100"; 
			} else {
				$initial_price = "initial_price";
			}


			$conn = $QueryBuilder->dbConnection();
			//var_dump($_SESSION);
			$query = $QueryBuilder->select(
				$conn,
				$options = array(
					"table" =>"products",
					"columns" => "id, product_name,". $initial_price ."  as initial_price",
					"where" => $whereClause,
				),
				$returnType = "idAsArray" 
			);

			if(!empty($query))
				foreach ($dummyArray as $key => $value) {
					# code...
					if(isset($query[$value["id"]])) {
						$dummyArray[$key] = $query[$value["id"]];
						$dummyArray[$key]['from_db'] = 1;
					}

				}

			// else
			// 	echo "nope";

			// var_dump($query);

			// var_dump($dummyArray);

			// $lastQueryKey = 0;


			// foreach ($dummyArray as $key => $value) {
			// 	# code...
			// 	echo $query[$lastQueryKey]["id"], $dummyArray[$key]['id'], $query[$lastQueryKey]["id"];
			// 	if(isset($query[$lastQueryKey]["id"]) && $dummyArray[$key]['id'] == $query[$lastQueryKey]["id"]) {
			// 		echo "eee";
			// 		$dummyArray[$key] = $query[$lastQueryKey];
			// 		$dummyArray[$key]['from_db'] = 1;
			// 		$lastQueryKey = $key+1; 
			// 		$foundArray[$dummyArray[$key]['id']] = $key;
			// 	}  else {
			// 		if(isset($foundArray[$dummyArray[$key]['id']])) {
			// 			$dummyArray[$key] = $dummyArray[$foundArray[$dummyArray[$key]['id']]];
			// 		} else {
			// 			$lastQueryKey = $key; 
			// 		}
			// 	}
			// }

			// var_dump($foundArray);


			$searchResult = $dummyArray;
			echo json_encode($searchResult);

	} 
	else {
		echo 0;
	}

	$QueryBuilder->closeConnection();
?>