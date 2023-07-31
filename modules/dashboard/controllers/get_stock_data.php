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
        SELECT t1.product_id, t1.mpp, t2.month, t2.type, t2.quantity
FROM (
    SELECT `source`.`product_id`, `source`.`mpp`
    FROM (
        SELECT `source`.`product_id` AS `product_id`, max(`source`.`vendor_invoice_item_id`) AS `max`, `source`.`mpp` AS `mpp`
        FROM (
            SELECT
                `vron`.`invoice_no` AS `invoice_no`,
                `vron`.`vendor_invoice_item_id` AS `vendor_invoice_item_id`,
                `vron`.`product_id` AS `product_id`,
                `vron`.`unit_price` AS `unit_price`,
                `vron`.`quantity` AS `quantity`,
                `vron`.`total_price_ron` AS `total_price_ron`,
                `vron`.`currency` AS `currency`,
                `vron`.`exchange_rate` AS `exchange_rate`,
                `vron`.`date_added` AS `date_added`,
                `vron`.`date` AS `date`,
                SUM(`vron`.`quantity`) over (
                    PARTITION BY `vron`.`product_id`
                    ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                ) AS `quantity_evolution`,
                SUM(`vron`.`total_price_ron`) over (
                    PARTITION BY `vron`.`product_id`
                    ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                ) AS `value_evolution`,
                TRUNCATE(
                    SUM(`vron`.`total_price_ron`) over (
                        PARTITION BY `vron`.`product_id`
                        ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                    ) / SUM(`vron`.`quantity`) over (
                        PARTITION BY `vron`.`product_id`
                        ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                    ),
                    2
                ) AS `mpp`
            FROM (
                SELECT
                    `vi`.`invoice_no` AS `invoice_no`,
                    `vii`.`id` AS `vendor_invoice_item_id`,
                    `vii`.`product_id` AS `product_id`,
                    `vii`.`unit_price` AS `unit_price`,
                    `vii`.`quantity` AS `quantity`,
                    `vii`.`total_price` AS `total_price`,
                    `vi`.`currency` AS `currency`,
                    `vi`.`exchange_rate` AS `exchange_rate`,
                    `vii`.`date_added` AS `date_added`,
                    `vi`.`date` AS `date`,
                    ROUND(
                        CASE WHEN `vi`.`currency` = 'Ron' THEN `vii`.`total_price` WHEN `vi`.`currency` = 'Euro' THEN `vii`.`total_price` * `vi`.`exchange_rate`
                    END,
                    2
                ) AS `total_price_ron`
                FROM
                    `vendor_invoice_items` `vii`
                JOIN `vendor_invoices` `vi`
                    ON (`vii`.`vendor_invoice_id` = `vi`.`id`)
                WHERE `date` > '2022-12-31'
                ORDER BY `vi`.`date`
            ) `vron`
            ORDER BY `vron`.`date`
        ) `source`
        GROUP BY `source`.`product_id`, `source`.`mpp`
    ) `source`
    LEFT JOIN (
        SELECT
            `vron`.`invoice_no` AS `invoice_no`,
            `vron`.`vendor_invoice_item_id` AS `vendor_invoice_item_id`,
            `vron`.`product_id` AS `product_id`,
            `vron`.`unit_price` AS `unit_price`,
            `vron`.`quantity` AS `quantity`,
            `vron`.`total_price_ron` AS `total_price_ron`,
            `vron`.`currency` AS `currency`,
            `vron`.`exchange_rate` AS `exchange_rate`,
            `vron`.`date_added` AS `date_added`,
            `vron`.`date` AS `date`,
            SUM(`vron`.`quantity`) over (
                PARTITION BY `vron`.`product_id`
                ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
            ) AS `quantity_evolution`,
            SUM(`vron`.`total_price_ron`) over (
                PARTITION BY `vron`.`product_id`
                ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
            ) AS `value_evolution`,
            TRUNCATE(
                SUM(`vron`.`total_price_ron`) over (
                    PARTITION BY `vron`.`product_id`
                    ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                ) / SUM(`vron`.`quantity`) over (
                    PARTITION BY `vron`.`product_id`
                    ORDER BY `vron`.`date` ROWS BETWEEN unbounded preceding AND CURRENT ROW
                ),
                2
            ) AS `mpp`
        FROM (
            SELECT
                `vi`.`invoice_no` AS `invoice_no`,
                `vii`.`id` AS `vendor_invoice_item_id`,
                `vii`.`product_id` AS `product_id`,
                `vii`.`unit_price` AS `unit_price`,
                `vii`.`quantity` AS `quantity`,
                `vii`.`total_price` AS `total_price`,
                `vi`.`currency` AS `currency`,
                `vi`.`exchange_rate` AS `exchange_rate`,
                `vii`.`date_added` AS `date_added`,
                `vi`.`date` AS `date`,
                ROUND(
                    CASE WHEN `vi`.`currency` = 'Ron' THEN `vii`.`total_price` WHEN `vi`.`currency` = 'Euro' THEN `vii`.`total_price` * `vi`.`exchange_rate`
                END,
                2
            ) AS `total_price_ron`
            FROM
                `vendor_invoice_items` `vii`
            JOIN `vendor_invoices` `vi`
                ON (`vii`.`vendor_invoice_id` = `vi`.`id`)
            WHERE `date` > '2022-12-31'
            ORDER BY `vi`.`date`
        ) `vron`
        ORDER BY `vron`.`date`
    ) `Question 46`
    ON `source`.`max` = `Question 46`.`vendor_invoice_item_id`
) t1
JOIN (
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
) AS t2
ON t1.product_id = t2.product_id
WHERE t1.product_id IS NOT NULL
ORDER BY t1.product_id, t2.month, t2.type
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
        $month = $row['month'];
        $productID = $row['product_id'];
        $type = $row['type'];
        $mpp = $row['mpp'];
        $quantity = $row['quantity'];

        // Initialize the month entry if it does not exist
        if (!isset($months[$month][$productID])) {
            $months[$month][$productID] = array(
                'initial_stock' => 0,
                'month_entries' => 0,
                'month_exits' => 0,
                'remaining_stock' => 0
            );
        }

        // Update the quantity based on the type (entry or exit)
        if ($type === 'entry') {
            $months[$month][$productID]['month_entries'] += $quantity;
        } elseif ($type === 'exit') {
            $months[$month][$productID]['month_exits'] += $quantity;
        }



         $months[$month][$productID]['initial_stock'] = isset($latestRemainingStock[$productID]) ? $latestRemainingStock[$productID] : 0; 


        $months[$month][$productID]['remaining_stock'] = $months[$month][$productID]['initial_stock'] + $months[$month][$productID]['month_entries'] - $months[$month][$productID]['month_exits'];


        $latestRemainingStock[$productID] = $months[$month][$productID]['remaining_stock'];
        $months[$month][$productID]['mpp'] = $mpp;


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
