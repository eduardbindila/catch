<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$host = "http://{$_SERVER['HTTP_HOST']}";

$conn = $QueryBuilder->dbConnection();
	
	$quoteQuery = $QueryBuilder->select(
			$conn,
			$options = array(
				"table" => "quotes",
				"columns" => "offer_date",
				"where" => "id = '".$_POST['quote_id']."'"
			)
		);

	$email = $_POST['data']['clientEmail'];

	//$email = "request@icatch.ro";

	if($quoteQuery) {

		$timestamp = strtotime($quoteQuery[0]['offer_date']);
		$quoteHash = base64_encode($timestamp.'/'.$_POST['quote_id']);

			$to = $email;
			$subject = "Quote #".$_POST['quote_id']." from iCatch";

			$message = "
			<html>
			<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>iCatch Quote</title>
			</head>
			<body>
			<p>Dear client, <br/><br/>

				".$_POST['data']['email_body']."</br>
				<a href='".$host."/offer/?hash=".$quoteHash."'>Review quote here</a> </br></br>

				Kind Regards,<br/>
				iCatch.ro

			</p>
			</body>
			</html>
			";

			



			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// // More headers
			$headers .= 'From: <office@icatch.ro>' . "\r\n";
			if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) { 
				//var_dump($message);
				$mailSend = true;
			} else {
				$mailSend = mail($to,$subject,$message,$headers);
			}

			if($mailSend) {
				
				$quoteUpdate = $QueryBuilder->update(
					$conn,
					$options = array(
						"table" => "quotes",
						"set" => ["`offer_sent`='1'"],
						"where" => "id = ".$_POST['quote_id']
					)
				);

				if($quoteUpdate) {
					echo true;
				} else {
					echo false;
				}

			} else {
				echo false;
			}
	}
	else {
		echo false;
	}


	$QueryBuilder->closeConnection();


?>