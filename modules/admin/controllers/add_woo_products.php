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


$productsListQuery = "WITH RECURSIVE cp AS (
    -- Recursive part to build the category hierarchy
    SELECT id, id AS nextid, parent_id, category_name, 1 AS level
    FROM categories
    UNION ALL
    SELECT cp.id, categories.id, categories.parent_id, categories.category_name, cp.level + 1
    FROM categories
    JOIN cp ON cp.parent_id = categories.id
)

-- Main query to fetch product information and corresponding shop_id
SELECT subquery.product_id, 
-- subquery.category_id, 
-- subquery.category_name, 
-- subquery.RootId, 
-- subquery.level, 
-- subquery.rn, 
shop_ids.shop_id as shop_category_id,
    p.product_name,
    p.initial_price, 
    ROUND(p.initial_price / 0.28 * 5 + 2, 2) as selling_price, 
    p.product_image,
    p.saga_quantity  as stock
FROM (
    -- Subquery to fetch product information and category hierarchy
    SELECT p.id AS product_id, cp.id AS category_id, cp.category_name, cp.nextid AS RootId, cp.level,
        ROW_NUMBER() OVER (PARTITION BY p.id ORDER BY cp.level DESC) AS rn
    FROM cp
    JOIN products p ON cp.id = p.parent_id
    WHERE p.parent_id IS NOT NULL
) subquery
JOIN shop_ids ON subquery.RootId = shop_ids.internal_id
JOIN products p ON subquery.product_id = p.id
WHERE subquery.rn = 2
    AND p.manufacturer = 'syl'
    AND p.initial_price <> 0
    AND p.active = 1
    AND NOT EXISTS (
        SELECT 1
        FROM shop_ids
        WHERE internal_id = subquery.product_id
    )
ORDER BY subquery.product_id ASC
LIMIT 1;
";


// Execute the query and fetch the products into an array
$products = $QueryBuilder->customQuery(
    $conn,
    $query = $productsListQuery
);


//printError($products);

// Prepare bulk category data
$bulkProductData['create'] = [];

// // WooCommerce API endpoint for products creation
$endpoint = 'products/batch';

foreach ($products as $product) {
       
        $descriptionQuery = "SELECT translation_key_id, translation  from translations t where language_code = 'ro' and translation_key_id = concat('".$product['product_id']."', '_description')";


        $description = $QueryBuilder->customQuery(
            $conn,
            $query = $descriptionQuery
        );

        $attributesQuery = " SELECT pf.*,
       si.shop_id,
       COALESCE(t.translation, fv.feature_value) AS translation
FROM product_features pf
JOIN shop_ids si ON si.internal_id = pf.feature_id
LEFT JOIN translations t ON pf.feature_value_id = t.translation_key_id AND t.language_code = 'ro'
JOIN feature_values fv ON pf.feature_value_id = fv.id
WHERE pf.product_id = '".$product['product_id']."' 
    AND pf.feature_id != 'product_name';";

    $attributes = $QueryBuilder->customQuery(
            $conn,
            $query = $attributesQuery
        );

        //printError($attributes);


        $attributesArray = [];

         foreach ($attributes as $attribute) {
                // code...

            //printError($attribute);

            $attributesArray[] = [
                    'id' => $attribute['shop_id'],
                    'options' => [$attribute['translation']],
                ];
            }  


        $bulkProductData['create'][] = 
        [
            "name" => $product['product_name'],
            "regular_price" => $product['selling_price'],
            "description" => $description[0]['translation'],
            "sku" => $product['product_id'],
            "stoc_quantity" => $product['stock'],
            "categories" => [
                [
                    'id' => $product['shop_category_id']
                ]
            ],
            "images" => [
                [
                    'src' => $product['product_image']
                ]
            ],
            'attributes' => $attributesArray
        ];


        
 }

//printError($bulkProductData);

try {
    // Make the API request
    $response = $woocommerce->post($endpoint, $bulkProductData);

    //printError($response);

    foreach ($response->create as $thisProduct) {

        //printError($thisProduct);

    if (isset($thisProduct->error)) {
        $errorMessage = 'Error creating product: ' . $thisProduct->error->message;
        if (isset($thisProduct->error->data->unique_sku)) {
            $errorMessage .= ' (SKU: ' . $thisProduct->error->data->unique_sku . ')';
        }
        echo $errorMessage . PHP_EOL;
    } else {
        // Debug statement to see the product response
        //print_r($thisProduct);

        // Handle success response
            echo 'Product created successfully! (ID: ' . $thisProduct->id . ')' . PHP_EOL;

            // Extract properties from the stdClass object
            $internalId = $thisProduct->sku;
            $shopId = $thisProduct->id;

            $successQuery = "INSERT INTO shop_ids (internal_id, shop_id) VALUES ('$internalId', '$shopId')";

            // Execute the query and insert the shop_id into the database
            $saveShopId = $QueryBuilder->customQuery($conn, $query = $successQuery);

    }
}
} catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
    // Handle other exceptions
    if ($e->getMessage() === 'Error: A term with the name provided already exists with this parent. [term_exists]') {
        echo 'Category already exists: ' . $product['category_name'];
        // You can choose to log or handle this case as needed
    } else {
        // Re-throw the exception if it's not the expected one
        throw $e;
    }
}





$QueryBuilder->closeConnection();

?>
