<?php

require_once('../../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

	$productQuery = $QueryBuilder->insert(
            $conn,
            $options = array(
                "table" => "products_import",
                "keys" => ["import_product_list_id", "product_id", "name", "price", "manufacturer"],
                "values" => $valuesArray,
            ),
            $multi = true
            
        );

	
$QueryBuilder->closeConnection();


var_dump($_POST);

?>