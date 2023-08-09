<?php
// Include the required files and setup the database connection
require_once('../../../config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$conn = $QueryBuilder->dbConnection();

// Function to retrieve the data from the database using the SQL query
function getDataFromDatabase($QueryBuilder, $conn)
{
    // Execute the SQL query
    $query = "
        SELECT 
    t1.month,
    t1.product_id,
    SUM(CASE WHEN t1.type = 'entry' THEN t1.quantity ELSE 0 END) AS sum_entries,
    SUM(CASE WHEN t1.type = 'exit' THEN t1.quantity ELSE 0 END) AS sum_exits,
    t2.mpp
FROM (
    SELECT vii.product_id,
            DATE_FORMAT(vi.date, '%m-%y') AS month,
            'entry' AS type,
            vii.quantity AS quantity 
        FROM vendor_invoice_items vii
        JOIN vendor_invoices vi ON vi.id = vii.vendor_invoice_id
        WHERE vi.date >= '2023-01-01'
    UNION ALL
    SELECT qi.product_id,
            DATE_FORMAT(p.invoice_date, '%m-%y') AS month,
            'exit' AS type,
            pi.package_quantity AS quantity
        FROM package_items pi
        JOIN quote_items qi ON qi.id = pi.quote_item_id
        JOIN packages p ON p.id = pi.package_id
        WHERE p.package_status_id = 4 AND p.invoice_date >= '2023-01-01'
) t1
LEFT JOIN (
    SELECT 
        product_id,
        MAX(vii.id) AS max_id,
        CASE 
            WHEN vi.currency = 'Ron' THEN unit_price 
            ELSE ROUND(unit_price * vi.exchange_rate, 2) 
        END AS mpp
    FROM 
        vendor_invoice_items vii
    JOIN 
        vendor_invoices vi ON vi.id = vii.vendor_invoice_id 
    GROUP BY 
        product_id
) AS t2
ON t1.product_id = t2.product_id
-- WHERE t1.product_id = '0048915'
GROUP BY t1.month, t1.product_id, t2.mpp
ORDER BY t1.product_id, t1.month;

    ";

    // Use your custom query builder to execute the query
    $projectsQuery = $QueryBuilder->customQuery(
        $conn,
        $query
    );

    return $projectsQuery;




}

// Function to display the table for each month
function displayMonthlyTable($data)
{
    $months = array();
    $latestRemainingStock = array();

    // Organize data by month
    foreach ($data as $row) {
        //printError($row);
        $month = $row['month'];
        $productID = $row['product_id'];
        $mpp = $row['mpp'];
        $month_entries = $row['sum_entries'];
        $month_exits = $row['sum_exits'];

        //$remainingStock = $row['remaining_stock'];


        // Initialize the month entry if it does not exist
        if (!isset($latestRemainingStock[$productID])) {
           $latestRemainingStock[$productID] = 0;
        }


        $months[$month][$productID]['mpp'] = $mpp;

        $months[$month][$productID]['month_entries'] = $month_entries;

        $months[$month][$productID]['month_exits'] = $month_exits;

       
         $months[$month][$productID]['initial_stock'] = $latestRemainingStock[$productID]; 


        $months[$month][$productID]['remaining_stock'] = $months[$month][$productID]['initial_stock'] + $months[$month][$productID]['month_entries'] - $months[$month][$productID]['month_exits'];

        // echo $month.' - '.$latestRemainingStock[$productID].' / ' ;

        $latestRemainingStock[$productID] = $months[$month][$productID]['remaining_stock'];

    }

  

    // Display the data in the table format for each month
    echo "<table border='1'>
        <tr>
            <th>Month</th>
            <th>Product ID</th>
            <th>MPP</th>
            <th>Initial Stock</th>
            <th>Initial Value</th>
            <th>Month Entries</th>
            <th>Month Entries Value</th>
            <th>Month Exits</th>
            <th>Month Exits Value</th>
            <th>Remaining Stock</th>
            <th>Remaining Stock Value</th>
        </tr>";

    foreach ($months as $month => $products) {
        foreach ($products as $productID => $stock) {
            $initialStock = $stock['initial_stock'] ?? 0;
            $monthEntries = $stock['month_entries'] ?? 0;
            $monthExits = $stock['month_exits'] ?? 0;
            $remainingStock = $stock['remaining_stock'] ?? 0;
            $mpp = $stock['mpp'] ?? 0;
            $initialStockValue = $initialStock * $mpp;
            $monthEntriesValue = $monthEntries * $mpp;
            $monthExitsValue = $monthExits * $mpp;
            $remainingStockValue = $remainingStock * $mpp;


            echo "<tr>
                <td>$month</td>
                <td>$productID</td>
                <td>$mpp</td>
                <td>$initialStock</td>
                <td>$initialStockValue</td>
                <td>$monthEntries</td>
                <td>$monthEntriesValue</td>
                <td>$monthExits</td>
                <td>$monthExitsValue</td>
                <td>$remainingStock</td>
                <td>$remainingStockValue</td>
              </tr>";
        }
    }

    echo "</table>";
}

// Retrieve the data from the database using the UNION ALL query
$data = getDataFromDatabase($QueryBuilder, $conn);

// Display the table for each month
displayMonthlyTable($data);

?>
