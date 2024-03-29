<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

//var_dump($_POST);
$conn = $QueryBuilder->dbConnection();

$isBulkSearch = isset($_POST['searchBulk']) && $_POST['searchBulk'] != "";

$isCriteriakSearch = isset($_POST['searchCriteria']) && $_POST['searchCriteria'] != "";

$isProductSearch = isset($_POST['product_name']) && $_POST['product_name'] != "";

$isWishlist = isset($_POST['wishlist']) && $_POST['wishlist'] != "";

//var_dump($_POST);

	$dummyArray = array();
	$foundArray = array();

	if(isset($_SESSION['is_client']) && $_SESSION['is_client'] && $_SESSION['user_type'] == 3) {
		if($_SESSION['client_discount'] > 0) {
			$initial_price = "initial_price/". $Pricing->listPercent ."* ". $_SESSION['client_discount']. " /100"; 
		} else {
			$initial_price = "initial_price/". $Pricing->listPercent;
		}
	} else {
		$initial_price = "initial_price";
	}

	
	if($isBulkSearch || $isWishlist) {

		
		if($isWishlist) {
			$rawBulkArray = $_POST['wishlist'];
		} else {
			$rawBulkArray = explode("\r\n", $_POST['searchBulk']);	
		}

		$idList = '"' . implode('", "', $rawBulkArray) . '"';
		

		foreach($rawBulkArray as $key=>$val)
		{ 
		     $dummyArray[$key]["id"] = $val;
		     $dummyArray[$key]["product_name"] = "";
		     $dummyArray[$key]["manufacturer"] = "";
		     $dummyArray[$key]["initial_price"] = 0.00;
		     $dummyArray[$key]["from_db"] = 0;
		}  

		

		$whereClause = "id IN (".$idList.") AND active = 1 ORDER BY FIELD(id,".$idList.");";
	

		
		//var_dump($_SESSION);
		$query = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" =>"products",
				"columns" => "id, product_name,product_description, product_diagrams, product_image, manufacturer, 1 as quantity, saga_quantity,". $initial_price ."  as initial_price",
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

		$searchResult = $dummyArray;
		echo json_encode($searchResult);

	}  elseif ($isCriteriakSearch OR $isProductSearch) {
		if($isCriteriakSearch) {
			$whereClause = "id LIKE '%".$_POST['searchCriteria']."%' AND active = 1";
		} else {
			$whereClause = "product_name LIKE '%".$_POST['product_name']."%' AND active = 1";
		}
		$criteriaQuery = $QueryBuilder->select(
				$conn,
				$options = array(
					"table" =>"products",
					"columns" => "id,product_description,product_diagrams, product_image, product_name, manufacturer, 1 as quantity,saga_quantity, 0 as from_db, ". $initial_price ."  as initial_price",
					"where" => $whereClause,
				)
			);
		echo json_encode($criteriaQuery);
	}
	else {
		echo 0;
	}

	$QueryBuilder->closeConnection();
?>