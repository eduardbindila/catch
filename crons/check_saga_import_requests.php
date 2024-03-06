<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$notificationId =  isset($_GET['notificationId']) ? $_GET['notificationId'] : '';

$status = '';

        $url = "https://contabi.nukkon.com/status/973B74EC-3A6E-400F-B30C-BC878D56ABE4/icatchdesign/".$notificationId;

        //echo $url;

        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        $response = curl_exec($curl);

        $response_error = "";
        $response_notification = "";

        if ($response === false) {
            // Eroare la request
            $status = 3;
            $response_error = curl_error($curl);
        } else {
            // Request cu succes
            

            // Afisare informații despre request
            //var_dump(curl_getinfo($curl));

            // Verificare dacă conținutul este JSON
            if (json_decode($response) !== null && json_last_error() === JSON_ERROR_NONE) {
                // Decodificare JSON și afișare
                $decodedData = json_decode($response, true);

                //print_r($decodedData);

                // Verificare dacă există cheia 'notificationId'
                if (isset($decodedData['status'])) {
                    // Extrage valoarea asociată cheii "notificationId"
                   if($decodedData['status'] == "OK")
                   {
                        $status = 2;
                        $response_notification = $decodedData['message'];
                   }
                        
                    elseif($decodedData['status'] == "KO")
                    {
                        $status = 3; 
                        $response_error = $decodedData['error'];
                    }
                        
                    elseif($decodedData['status'] == "pending")
                        $status="1";
                }
            } 
        

        curl_close($curl);

        echo $status;
        // echo $response_error;
        // echo $response_notification;


        $conn = $QueryBuilder->dbConnection();

        //Actualizare în baza de date
        $updateRequests = $QueryBuilder->update(
            $conn,
            $options = array(
                "table" => "saga_import_details",
                "set" => [
                    "`status`=" . $status,
                    "`response_error`='" . $response_error . "'"
                ],
                "where" =>  "`response_notification`='" . $notificationId . "'"
            )
        );

        //echo $conn->error;

    }


    $QueryBuilder->closeConnection();





	
?>