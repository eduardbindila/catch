<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

if(!isset($projectID)) {
	$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/sweetalert/sweetalert.css');
$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css');
//$LoadHTMLArtefacts->setLink($_WPATH['COMMON_INTERFACE'].'plugins/bootstrap-select/css/bootstrap-select.css');



$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-validation/jquery.validate.js');
	$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/bootstrap-notify/bootstrap-notify.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/sweetalert/sweetalert.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/jquery.dataTables.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.flash.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/jszip.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/pdfmake.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/vfs_fonts.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.html5.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/buttons.print.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/dataTables.rowGroup.min.js');
$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'plugins/jquery-datatable/extensions/export/dataTables.select.min.js');
}



$LoadHTMLArtefacts->setScript($_WMPATH['CART_VIEWS'].'cart-search.js');



$errorMessage = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST['searchType'])){

	$isBulkSearch = isset($_POST['searchBulk']) && $_POST['searchBulk'] != "";


	$whereClause = '';

	if(isset($_POST['searchTemporary'])) {
		$table = 'products_temp';
		$is_temporary = "1";

		$searchTemporary = 1;
	} else {
		$table = 'products';
		$is_temporary = "0";
		$searchTemporary = 0;
	}

	$dummyArray = array();
	$foundArray = array();


	if($_POST['searchType'] == 'product-id-contains') {
		$whereClause = "id LIKE '%".$_POST['searchCriteria']."%'";
	}
	else if($_POST['searchType'] == 'description') {
		$whereClause = "product_description LIKE '%".$_POST['searchCriteria']."%'";
	} else {
		

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


		} else {
			$whereClause = "id = '".$_POST['searchCriteria']."'";
		}
	}

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
			"where" => $whereClause
		)
	);

	if(is_string($query)) {
		$_SESSION['login-error-class'] = 'loggin-error';
		$errorMessage = $query;
		
	} else if(sizeof($query) == 0){
		

		$_SESSION['login-error-class'] = 'loggin-error';
		$errorMessage = 'No product has been found';
	} else {
		
		$_SESSION['login-error-class'] = '';
	}

	//var_dump($query);

	$lastQueryKey = 0;

	if($isBulkSearch) {

			foreach ($dummyArray as $key => $value) {
				# code...
				if(isset($query[$lastQueryKey]["id"]) && $dummyArray[$key]['id'] == $query[$lastQueryKey]["id"]) {
					$dummyArray[$key] = $query[$lastQueryKey];
					$dummyArray[$key]['from_db'] = 1;
					$lastQueryKey = $key+1; 
					$foundArray[$dummyArray[$key]['id']] = $key;
				}  else {
					if(isset($foundArray[$dummyArray[$key]['id']])) {
						$dummyArray[$key] = $dummyArray[$foundArray[$dummyArray[$key]['id']]];
					} else {
						$lastQueryKey = $key; 
					}
					
				}
				

			}

			var_dump($foundArray);


			$searchResult = $dummyArray;

	} else {
		$searchResult =  $query;
	}

	

	$QueryBuilder->closeConnection();


	//var_dump($query);

}
else {
	//$_SESSION['login-error-class'] = '';
}

include($_MPATH['CART_VIEWS'].'cart_search_view.php');

?>