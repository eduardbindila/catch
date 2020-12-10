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

			$htmlContent = "
			<html>
			<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>iCatch Quote</title>
			</head>
			<body>
			<p>Dear client, <br/><br/>

				".$_POST['data']['email_body']."</br>
				<a href='".$host."/offer/?hash=".$quoteHash."'>Review quote here</a> <br/><br/>

				Kind Regards,<br/>
				iCatch.ro

			</p>
			</body>
			</html>
			";

			



			// Always set content-type when sending HTML email
			//$headers = "MIME-Version: 1.0" . "\r\n";
			// Boundary  
			$semi_rand = md5(time());  
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
			 
			// Sender 
			$from = 'office@icatch.ro'; 
			$fromName = 'iCatch Design'; 

						// Header for sender info 
			$headers = "From: $fromName"." <".$from.">"; 
			 
			

			

			if($_POST['type'] !== "quote") {

					// Boundary  
				$semi_rand = md5(time());  
				$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
				 
				// Headers for attachment  
				$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
				 
				// Multipart boundary  
				$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
				"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  

				// Attachment file 
				$file = "../../..//uploads/".$_POST['type']; 
				// Preparing attachment 
				if(!empty($file) > 0){ 

					//$file = "../../../uploads/17340_default_full.jpg";
					//echo 'nope   '. $file;
				    if(is_file($file)){ 
				    	//echo $file;
				        $message .= "--{$mime_boundary}\n"; 
				        $fp =    @fopen($file,"rb"); 
				        $data =  @fread($fp,filesize($file)); 
				 
				        @fclose($fp); 
				        $data = chunk_split(base64_encode($data)); 
				        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
				        "Content-Description: ".basename($file)."\n" . 
				        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
				        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
				    } 
				} 

				$message .= "--{$mime_boundary}--"; 
			} else {

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				$message = $htmlContent;
			}
			
			
			
			$mailSend = mail($to,$subject,$message,$headers);

			//$mailSend = true;
			

			if($mailSend) {
				if($_POST['type'] == 'quote')
				{
					$quoteUpdate = $QueryBuilder->update(
						$conn,
						$options = array(
							"table" => "quotes",
							"set" => ["`offer_sent`='1'"],
							"where" => "id = ".$_POST['quote_id']
						)
					);
				} else {
					$quoteUpdate = $QueryBuilder->update(
						$conn,
						$options = array(
							"table" => "quote_files",
							"set" => ["`is_sent`=1","`sent_date`='".strtotime('now')."'"] ,
							"where" => "file_path = '".$_POST['type']."'"
						)
					);
				}
				

				if($quoteUpdate) {
					// echo 'sarma adevarata';
					echo true;
				} else {
					// echo 'sarma falsa 1';
					echo false;
				}

			} else {
				// echo 'sarma falsa 2';
				echo false;
			}
	}
	else {
		// echo 'sarma falsa 3';
		echo false;
	}


	$QueryBuilder->closeConnection();


?>