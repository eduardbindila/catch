<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 



require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');


    $conn = $QueryBuilder->dbConnection();

    $productQuery = $QueryBuilder->select(
        $conn,
        $options = array(
            "table" => "products",
            "columns" => "id",

        ),
        $returnType = 'insertedProducts'

    );

    echo json_encode($productQuery);

    $QueryBuilder->closeConnection();
?>