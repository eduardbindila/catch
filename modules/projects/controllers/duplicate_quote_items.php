<?php

require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// Fetch the selected quote items from DB
$quoteItemsQuery = $QueryBuilder->select(
    $conn,
    [
        "table"   => "quote_items",
        "columns" => "*",
        "where"   => "id in (" . $QueryBuilder->arrayToSql($_POST['quote_items'], "'") . ")"
    ]
);

// --- Build column keys (remove id, and last 6 cols)
$keys = array_keys($quoteItemsQuery[0]);
$keys = array_splice($keys, 1);
$keys = array_splice($keys, 0, -6);

// Remove unwanted columns entirely
$keys = array_diff($keys, [
    'aquisition_price',
    'reserved_stock',
    'order_number',
    'order_date',
    'ordered_quantity',
    'promise_date',
    'invoiced_quantity'
]);
$keys = array_values($keys); // reindex

$valuesArray = [];

// --- Prepare clean insert rows
foreach ($quoteItemsQuery as $quoteItem) {

    // Escape special characters
    $quoteItem['customer_description'] = addslashes($quoteItem['customer_description']);
    $quoteItem['destination'] = addslashes($quoteItem['destination']);

    // Remove first element (the ID)
    array_splice($quoteItem, 0, 1);

    // Replace and add values
    $quoteItem['quote_id'] = $_POST['quote_id'];
    $quoteItem['rejection_reason'] = 1;

    // Remove columns we don't want to insert (DB will set defaults)
    unset(
        $quoteItem['aquisition_price'],
        $quoteItem['reserved_stock'],
        $quoteItem['order_number'],
        $quoteItem['order_date'],
        $quoteItem['ordered_quantity'],
        $quoteItem['promise_date'],
        $quoteItem['invoiced_quantity']
    );

    // Align row values exactly to the order of $keys
    $row = [];
    foreach ($keys as $k) {
        $v = $quoteItem[$k] ?? null; // missing -> NULL
        if ($v === '') $v = null;    // empty string -> NULL
        $row[] = $v;
    }

    $valuesArray[] = $row;
}

// --- Optional debug check
// echo 'keys=' . count($keys) . ', first_row=' . count($valuesArray[0]) . PHP_EOL;
// print_r($keys);
// print_r($valuesArray[0]);

// --- Execute multi-insert
$inserQuoteItems = $QueryBuilder->insert(
    $conn,
    [
        "table"  => "quote_items",
        "keys"   => $keys,
        "values" => $valuesArray
    ],
    $multi = true
);

// --- Output results
echo json_decode($inserQuoteItems);
echo $conn->error;

$QueryBuilder->closeConnection();

?>
