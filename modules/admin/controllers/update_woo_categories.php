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


$query = "SELECT c.id, t.translation AS category_name, c.parent_id
FROM categories AS c
JOIN translations AS t ON t.translation_key_id = c.id
WHERE c.parent_id = '' OR c.parent_id IN (SELECT id FROM categories WHERE parent_id = '')
AND t.language_code = 'ro';";

// Execute the query and fetch the categories into an array
$categories = $QueryBuilder->customQuery(
    $conn,
    $query = $query
);


// printError($categories);

// Prepare bulk category data
$bulkCategoryData = [];

// // WooCommerce API endpoint for categories creation
$endpoint = 'products/categories';

foreach ($categories as $category) {
        // // Existing category, perform update


        $parentQuery = "SELECT shop_id FROM shop_ids where internal_id = '".$category["parent_id"]."'";

        // Execute the query and fetch the categories into an array
        $parentId = $QueryBuilder->customQuery(
            $conn,
            $query = $parentQuery
        );

        printError($parentId);

        $bulkCategoryData = [
            'name' => $category['category_name'],
            'slug' => $category['id'],
            'parent' => empty($parentId) ? 0 : intval($parentId[0]['shop_id']) ,
            // Add more category fields here if needed
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

?>