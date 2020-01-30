<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 
require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/connection.php');


//Query Handling
//========================//

$QueryBuilder= new QueryBuilder();

$Pricing= new Pricing();


//Session Handling
//========================//
$SessionState = new SessionState(); 
$SessionState->sessionStart();


if($_subSectionName == "import" && !isset($_SESSION['user_access']['admin']) || $_subSectionName == "admin" && !isset($_SESSION['user_access']['supervisor'])) {
	header("HTTP/1.1 301 Moved Permanently");
	header( 'Location: /404' ) ;
} 

if(!isset($_SESSION['user_id'])){
	$_SESSION['isLoggedIn'] = true;
	$_SESSION['login-error-class'] = '';
	$_SESSION['name'] = "Visitor";
	$_SESSION['user_id'] = 0;
	$_SESSION['user_type'] = 4;
	$_SESSION['is_client'] = 0;

	$conn = $QueryBuilder->dbConnection();

	$_SESSION['user_access'] = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "access",
			"columns" => "access_elements.name as id",
			"innerJoin" => "access_elements ON access.access_type = access_elements.id ",
			"where" => "access.user_type = '".$_SESSION['user_type']."'"
		),
		$returnType = "idAsArray"
	);



	$QueryBuilder->closeConnection();
}



// var_dump($_SESSION);

$_clientView = isset($_SESSION['user_access']['client-grid']); 

$_salesView = isset($_SESSION['user_access']['sales-grid']);

$_supervisorView = isset($_SESSION['user_access']['supervisor']);

$_adminView = isset($_SESSION['user_access']['admin']);


//var_dump($_SESSION);
//Links Handling
//========================//
$LoadHTMLArtefacts = new LoadHTMLArtefacts(); 

//Get Details 
//========================//
$GetDetails = new GetDetails(); 


//Example for controller
//$LoadHTMLArtefacts->setLink($href=$_WPATH['COMMON_INTERFACE']."css/style.css");

$LoadHTMLArtefacts->setScript($_WPATH['COMMON_INTERFACE'].'js/script.js');


?>
