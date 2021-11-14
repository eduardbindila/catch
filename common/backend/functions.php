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

//var_dump($_SESSION);

// echo $_subSectionName;

//echo $_sectionName;

//echo $_pageName;

if($_subSectionName == "import" && !isset($_SESSION['user_access']['admin']) || $_subSectionName == "manage" && !isset($_SESSION['user_access']['admin']) || $_sectionName == "admin" && !isset($_SESSION['user_access']['supervisor']) || $_subSectionName == "product" && !isset($_SESSION['user_access']['supervisor'])) {
	header("HTTP/1.1 301 Moved Permanently");
	header( 'Location: /404' ) ;
} 

if($_sectionName == "offer" ) {
	$SessionState->destroy();
}



if(!isset($_SESSION['user_id'])){
	$_SESSION['isLoggedIn'] = false;
	$_SESSION['login-error-class'] = '';
	$_SESSION['name'] = "Visitor";
	$_SESSION['user_id'] = 0;
	$_SESSION['user_type'] = 4;
	$_SESSION['is_client'] = 0;
	$_SESSION['client_discount'] = 0;
	$_SESSION['country'] = "RO";

// } else {

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

if($_sectionName !== "cron" && $_sectionName !== "offer" &&  $_SESSION['name'] == "Visitor" && $_subSectionName !== "login" && $_subSectionName !== "getRejectionReason" && $_subSectionName !== "updateQuote" && $_subSectionName !== "confirmQuote" && $_subSectionName !== "getQuoteFiles" && $_sectionName !== 'download') {
	$SessionState->redirectLogin();

}


if($_sectionName !== "cron" && $_sectionName !== "offer" &&  $_SESSION['user_type'] == 4 && $_sectionName !== 'login' && $_sectionName !== 'ajax' && $_sectionName !== 'download') {
	$SessionState->redirectLogin();
}


// if(  $_SESSION['user_type'] == 3 && $_sectionName !== 'quote' && $_sectionName !== 'dashboard' && $_sectionName !== 'ajax') {
// 	$SessionState->redirectLogin();
// }


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

$actual_link = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$host = "https://{$_SERVER['HTTP_HOST']}";

$userId = basename($actual_link);

$urlArray = parse_url($actual_link);


?>
