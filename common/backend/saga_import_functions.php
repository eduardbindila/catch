<?php 

$target =  isset($_GET['target']) ? $_GET['target'] : '0269';

function requestUrl($requestType, $target) {
    return "https://contabi.nukkon.com/".$requestType."/973B74EC-3A6E-400F-B30C-BC878D56ABE4/icatchdesign/".$target;
}

function callSaga($url,$json) {

	$json = htmlspecialchars_decode($json);

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

    curl_close($curl);



    return $result = [
                'status' => $status,
                'responseError' => $response_error,
                'notificationId' => $notificationId
                ];
}

function checkNotificationId($notificationId) {

	$url = "https://contabi.nukkon.com/status/973B74EC-3A6E-400F-B30C-BC878D56ABE4/icatchdesign/".$notificationId;

	$curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        $response = curl_exec($curl);

        return $response;
}


function checkJson($data, $requestType) {
    $result = ["lista" => []];

    foreach ($data[$requestType] as $entry) {
        if (!empty($entry['codArt'])) {
            $result['lista'][] = [
                "tip" => "ART",
                "cod" => $entry['codArt']
            ];
        }
    }

    if($requestType == 'iesiri')
    {
        $tip = "CLI";
    }
    else  {
        $tip = "FUR";
    }

    $result['lista'][] = ["tip" => $tip, "cod" => isset($entry["cod"]) ? $entry["cod"] : [] ];

    //var_dump($result);

    return $result;
}


?>