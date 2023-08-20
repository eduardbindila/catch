<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');
require_once($_PATH['LIB'].'/WooCommerce/Client.php');
// Include all WooCommerce API files
foreach (glob($_PATH['LIB'].'/WooCommerce/HttpClient/*.php') as $filename) {
    require_once $filename;
}
use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    $store_url, // Your store URL
    $consumer_key, // Your consumer key
    $consumer_secret, // Your consumer secret
    [
        'version' => 'wc/v3',
        'timeout' => 30,
        'verify_ssl' => false,
    ]
);


$conn = $QueryBuilder->dbConnection();


$query = "SELECT c.id, t.translation as category_name
FROM features as c 
JOIN translations AS t ON t.translation_key_id = c.id
WHERE t.language_code = 'ro'
AND c.id NOT IN (SELECT internal_id FROM shop_ids)";


// Execute the query and fetch the categories into an array
$categories = $QueryBuilder->customQuery(
    $conn,
    $query = $query
);


// printError($categories);

// Prepare bulk category data
$bulkCategoryData = [];

// // WooCommerce API endpoint for categories creation
$endpoint = 'products/attributes';

foreach ($categories as $category) {
        // // Existing category, perform update

        $id = generate_unique_id($category['id']);
        $bulkCategoryData = [
            'name' => $category['category_name'],
            'slug' => $id // Using adjusted ID as slug
        ];


        printError($bulkCategoryData);

 try {
        // Make the API request
        $response = $woocommerce->post($endpoint, $bulkCategoryData);

        // Handle success response
        echo 'Category created successfully!';

        $successQuery = "INSERT into shop_ids (internal_id, shop_id) values ('".$category['id']. "', '".$response->id. "')";

        // Execute the query and fetch the categories into an array
        $saveShopId = $QueryBuilder->customQuery(
            $conn,
            $query = $successQuery
        );

    } catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
        // Handle the exception if a term with the same name and parent already exists
        if ($e->getMessage() === 'Error: A term with the name provided already exists with this parent. [term_exists]') {
            echo 'Category already exists: ' . $category['category_name'];
            // You can choose to log or handle this case as needed
        } else {
            // Re-throw the exception if it's not the expected one
            throw $e;
        }
    }
 }



$QueryBuilder->closeConnection();


// Custom function to generate a unique and adjusted ID
function generate_unique_id($id) {
    $max_length = 27;
    $uniqid_length = strlen(uniqid());
    
    if ($max_length <= $uniqid_length) {
        return substr(uniqid(), 0, $max_length);
    }
    
    $adjusted_id = substr($id, 0, $max_length - $uniqid_length);
    $adjusted_id .= '_' . uniqid();
    return $adjusted_id;
}

?>
