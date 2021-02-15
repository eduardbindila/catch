<?php

require_once('config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $conn = $QueryBuilder->dbConnection();

	$query = $QueryBuilder->select(
		$conn,
		$options = array(
			"table" => "users",
			"columns" => "name, id, type_id, isClient, country",
			"where" => "username = '".$_POST['username']."' AND password = '".$_POST['password']."'"
		)
	);

	if($query) {

		$_SESSION['isLoggedIn'] = true;
		$_SESSION['login-error-class'] = '';
		$_SESSION['name'] = $query[0]['name'];
		$_SESSION['user_id'] = $query[0]['id'];
		$_SESSION['user_type'] = $query[0]['type_id'];
		$_SESSION['is_client'] = $query[0]['isClient'];
		$_SESSION['country'] = $query[0]['country'];


		if(isset($_SESSION['is_client']) && $_SESSION['is_client']) {
			
			$discountQuery = $QueryBuilder->select(
				$conn,
				$options = array(
					"table" => "clients",
					"columns" => "discount",
					"where" => "id = '".$_SESSION['is_client']."'"
				)
			);

			$_SESSION['client_discount'] = $discountQuery[0]['discount'];


		} else {
			$_SESSION['client_discount'] = 0;
		}

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

		$SessionState->redirectLoggedIn();

	
	} else {
		$_SESSION['login-error-class'] = 'loggin-error';
		$_SESSION['isLoggedIn'] = false;
	}

	$QueryBuilder->closeConnection();

}
else {
	$_SESSION['login-error-class'] = '';
}









include($_MPATH['AUTH_VIEWS'].'login-view.php');






?>