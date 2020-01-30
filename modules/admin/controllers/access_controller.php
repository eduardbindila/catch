<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');



$conn = $QueryBuilder->dbConnection();

	$accessElements = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "access_elements",
			"columns" => "*"
		),
		$returnType = "idAsArray"
	);

	$QueryBuilder->closeConnection();



if(isset($_POST['access'])) {

	foreach ($_POST['access'] as $key => $value) {
		$accessElements[trim($value)]['hasAccess'] = 1;
	}

	
	foreach ($accessElements as $k => $val) {
		# code...
		if(isset($val['hasAccess'])) {
			//$query = "INSERT INTO access (`user_type`, `access_type`) VALUES (".$_POST['user_type_id'].",".$val['id'].") ON DUPLICATE KEY UPDATE `user_type` = VALUES(".$_POST['user_type_id']."), `access_type` = VALUES(".$val['id'].")"; 
			$query = "INSERT INTO access (user_type, access_type) SELECT ".$_POST['user_type_id'].",".$val['id']." FROM DUAL WHERE NOT EXISTS (SELECT user_type, access_type FROM access WHERE user_type=".$_POST['user_type_id']." AND access_type=".$val['id'].")";
		}else {
			$query = "DELETE from access WHERE `user_type` =".$_POST['user_type_id']." AND `access_type` = ".$val['id']; 
		}

		//echo $query;

		$results = mysqli_query($conn, $query);	
	}
}

	include($_MPATH['ADMIN_VIEWS'].'access_view.php');

?>