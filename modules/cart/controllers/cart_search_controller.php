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

	$whereClause = '';

	if(isset($_POST['searchTemporary'])) {
		$table = 'products_temp';
		$searchTemporary = 1;
	} else {
		$table = 'products';
		$searchTemporary = 0;
	}


	if($_POST['searchType'] == 'product-id-contains') {
		$whereClause = "id LIKE '%".$_POST['searchCriteria']."%'";
	}
	else if($_POST['searchType'] == 'description') {
		$whereClause = "product_description LIKE '%".$_POST['searchCriteria']."%'";
	} else {
		

		if(isset($_POST['searchBulk'])) {

			$rawBulkArray = explode("\r\n", $_POST['searchBulk']);

			$and = 'OR ';
			foreach ($rawBulkArray as $key => $value) {
				if($key == count($rawBulkArray)-1) {
					$and = '';
				}

				$whereClause .= "id ='".trim($value)."' ".$and;
			}

		} else {
			$whereClause = "id = '".$_POST['searchCriteria']."'";
		}
	}


    $conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => $table,
			"columns" => "*",
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

		$searchResult = $query;
	}


	$QueryBuilder->closeConnection();

}
else {
	//$_SESSION['login-error-class'] = '';
}

include($_MPATH['CART_VIEWS'].'cart_search_view.php');

?>