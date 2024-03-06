<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


$target =  isset($_GET['target']) ? $_GET['target'] : '0271';


function requestUrl($requestType, $target) {
    return "https://contabi.nukkon.com/".$requestType."/973B74EC-3A6E-400F-B30C-BC878D56ABE4/icatchdesign/".$target;
}

//echo 'aaa';


$conn = $QueryBuilder->dbConnection();

if(isset($_GET['request'])) {

    $where = "sid.id = ".$_GET['request'];

} else {

     $where = "status = 5";

}

    $sagaRequests = $QueryBuilder->select(
        $conn,
        $options = array(
            "table" => "saga_import_details sid",
            "columns" => "sid.*, srt.name as request_type_name",
            "leftJoin" => 'saga_request_types srt ON srt.id = sid.request_type_id',
            "where" => $where
        )
    );



    //printError($sagaRequests);


    foreach($sagaRequests as $request)
    {
        // printError($request);


        $url = requestUrl($request['request_type_name'], $target);

        //echo $url;

        $json = htmlspecialchars_decode($request['request']);


        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        $response = curl_exec($curl);

        $response_error = "";
        if ($response === false) {
            // Eroare la request
            $status = 5;
            $response_error = curl_error($curl);
            $notificationId = 0;
        } else {
            // Request cu succes
            $status = 1;

            // Afisare informații despre request
            //var_dump(curl_getinfo($curl));

            // Verificare dacă conținutul este JSON
            if (json_decode($response) !== null && json_last_error() === JSON_ERROR_NONE) {
                // Decodificare JSON și afișare
                $decodedData = json_decode($response, true);
                //print_r($decodedData['notificationId']);

                // Verificare dacă există cheia 'notificationId'
                if (isset($decodedData['notificationId'])) {
                    // Extrage valoarea asociată cheii "notificationId"
                    $notificationId = $decodedData['notificationId'];
                } else {
                    $notificationId = 0;
                }
            } else {
                // Afișare conținut brut
                //echo $response;
                $notificationId = 0;
            }
        }

        echo $notificationId;

        curl_close($curl);

        // Actualizare în baza de date
        $updateRequests = $QueryBuilder->update(
            $conn,
            $options = array(
                "table" => "saga_import_details",
                "set" => [
                    "`status`=" . $status,
                    "`response_notification`='" . $notificationId . "'",
                    "`response_error`='" . $response_error . "'"
                ],
                "where" => "id = " . $request['id']
            )
        );

        //echo $conn->error;

    }


    $QueryBuilder->closeConnection();





	
?>