<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

set_time_limit ( 0 );


require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$root = "https://www.sylvania-lighting.com/product/en-int/products/";

 $conn = $QueryBuilder->dbConnection();

// if(isset($_POST['sync_products']) && $_POST['sync_products']) {
//     $all_products = $QueryBuilder->select(
//         $conn,
//         $options = array(
//             "table" => 'import_products_list',
//             "columns" => "*",
//             "where" => 'imported=0 and inexistent=0'
//         ),
//         // $returnType = 'idAsArray'
//     );

//     $db_products = $QueryBuilder->select(
//         $conn,
//         $options = array(
//             "table" => 'products',
//             "columns" => "id"
//         )
//     );
// }
// else {
//     $all_products = $_POST["all_products"];
// }

//COMMETED THE TOP TO ADD A NEW QUERY

 $db_products = $QueryBuilder->select(
        $conn,
        $options = array(
            "table" => 'products',
            "columns" => "id",
            "where" => "manufacturer='syl'",
        )
    );


 $all_products = $db_products;



//$all_products = array_slice($all_products,0,1);

// var_dump($db_products);

// break;

//Set Imported as true before sync. Should be commented

// foreach ($db_products as $key => $value) {
//     if(isset($all_products[$value['id'])]) {
//         $updateSyncProducts = $QueryBuilder->update(
//             $conn,
//             $options = array(
//                 "table" => "import_products_list",
//                 "set" => [
//                     "`imported`=1"
//                     ],
//                 "where" => "id =".$value['id']
//             )
//         );
//     }

// }






CLASS ScrapHelpers {

        function sluggify($s){
             $removeSlashes = str_replace('/', '_', $s);
             $removeSlashes = str_replace('&', '_', $removeSlashes);
             $removeSlashes = str_replace('(', '_', $removeSlashes);
             $removeSlashes = str_replace(')', '_', $removeSlashes);
             $removeSlashes = str_replace('+', '_', $removeSlashes);
             $removeSlashes = str_replace('Ø', '_', $removeSlashes);
             $removeSlashes = str_replace('%', '_', $removeSlashes);
             $removeSlashes = str_replace('°', '_', $removeSlashes);
             $removeSlashes = str_replace('~', '_', $removeSlashes);
             $removeSlashes = str_replace('µ', '_', $removeSlashes);
            return strtolower(str_replace(' ', '_', $removeSlashes));
        }

        function cleanTitle($s){
             $removeSlashes = str_replace(';', '', $s);
             return $removeSlashes = str_replace('"', '', $removeSlashes);
        }

        function getURLfromBg($bg) {
            $bgImage = explode('(', $bg);
            $bgImage = explode(')', $bgImage[1])[0];
            return $bgImage;
        } 
    }

    $_ScrapHelpers = new ScrapHelpers();

foreach ($all_products as $key => $productItem) {

    //var_dump($productItem);
 
    $html = file_get_contents($root.$productItem['id'].'/');
    // if(!$html)
    // {
    //     //echo 'asd';
    //     $updateImportedProducts = $QueryBuilder->update(
    //             $conn,
    //             $options = array(
    //                 "table" => "import_products_list",
    //                 "set" => [
    //                     "`inexistent`=1"
    //                     ],
    //                 "where" => "id ='".$productItem['id']."'"
    //             )
    //         );
    //     continue;
    // }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
      if($dom->doctype !== null)
    {
        $xpath = new DOMXPath($dom);
        $product_description_class = "product-overview__copy";
        $product_image_class = "product-overview__image";
        $product_title_class = "intro-block__title";
        $product_infopanels_class = "info-panels";
        $product_table_class = "info-panels";
        $product_data_section_id = "tab-product-data-table";
        $breadcrumb_link_class = "breadcrumb__link";

    // $category_path = $xpath->query('//div[@class="'.$product_description.'"]');

  

        

        $product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

        $product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

        $product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

        $product_infopanels = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

        $product_data = $xpath->query('//section[contains(@id,"'.$product_data_section_id.'")]');

        $breadcrumbData = $dom->saveHTML($xpath->query('//div[contains(@class,"breadcrumb")]')[0]);

        $breadcrumbRaw = $xpath->query('//div[contains(@class,"breadcrumb")]/div')[0];


        $breadcrumb = explode("\r\n", $breadcrumbRaw->nodeValue);

        $breadcrumbArray = array_splice($breadcrumb, 3, -2);
        
        $categoryId = "";

        $breadcrumbIndex = 0;  

        $product_title = $_ScrapHelpers->cleanTitle($product_title); 

        foreach ($breadcrumbArray as $node => $value) {

            $value = trim($value);

            if($breadcrumbIndex > 0) {
                $categorySep = "-";
            } else {
                $categorySep = "";
            }

            $categoryId = $categoryId.$categorySep.$_ScrapHelpers->sluggify($value);

            $breadcrumbIndex++;
        }  

        $productInfo = array( [
                    $productItem['id'], 
                    trim($product_title), 
                    htmlspecialchars($product_description), 
                    htmlspecialchars($product_infopanels), 
                    $product_image, 
                    $categoryId, 
                ]);

        //var_dump(htmlspecialchars($product_description));

        // var_dump($categoryId);  

        // var_dump(htmlspecialchars($product_title));

        $productQuery = $QueryBuilder->update(
            $conn,
            $options = array(
                "table" => "products",
                "set" =>  [
                    "`product_description`='".addslashes(htmlspecialchars($product_description))."'",
                    "`product_diagrams`='".addslashes(htmlspecialchars($product_infopanels))."'",
                    "`product_image`='".$product_image."'", "`parent_id`='".$categoryId."'",
                    "`last_updated_date` = '".strtotime("now")."'"
                ],
                "where" => "id='".$productItem['id']."'"
            )
        );


        //var_dump($productQuery);

        // if($productQuery) {
        //     $updateImportedProducts = $QueryBuilder->update(
        //         $conn,
        //         $options = array(
        //             "table" => "import_products_list",
        //             "set" => [
        //                 "`imported`=1"
        //                 ],
        //             "where" => "id ='".$productItem['id']."'"
        //         )
        //     );
        // } else {
        //     echo $productItem['id']." has an issue";

        //     $updateImportedProducts = $QueryBuilder->update(
        //         $conn,
        //         $options = array(
        //             "table" => "import_products_list",
        //             "set" => [
        //                 "`hasIssue`=1"
        //                 ],
        //             "where" => "id ='".$productItem['id']."'"
        //         )
        //     );
        //     break;

            
        // }

        //COMMENTED ABOVE AS WE DON'T NEED IT FOR DATA UPDATING

        foreach ($product_data as $key => $value) {
            

            $table = $value->getElementsByTagName('table');

            foreach($table as $k => $val) {

                $feature_category = $val->getElementsByTagName('thead')[0]->textContent;

                $feature_category_name = trim($feature_category);

                //var_dump($feature_category);

                $featureCategoryQuery = $QueryBuilder->insert(
                    $conn,
                    $options = array(
                        "table" => "feature_categories",
                        "keys" => ["id","feature_category_name"],
                        "values" => [
                            $_ScrapHelpers->sluggify($feature_category_name),
                            $feature_category_name, 
                        ]
                    )
                );

                $tbody = $val->getElementsByTagName('tbody');

                foreach ($tbody as $i => $v) {
                    # code...
                    $tr = $v->getElementsByTagName('tr');

                    $features_array = array ();

                     foreach ($tr as $x => $w) {
                         # code...

                        $td = $w->getElementsByTagName('td');

                        $feature_name = trim($td[0]->textContent);

                        $feature_value_name = trim($td[1]->textContent);

                        $featuresQuery = $QueryBuilder->insert(
                            $conn,
                            $options = array(
                                "table" => "features",
                                "keys" => ["id","feature_name", "feature_category_id"],
                                "values" => [
                                    $_ScrapHelpers->sluggify($feature_name),
                                    $feature_name,
                                    $_ScrapHelpers->sluggify($feature_category_name) 
                                ]
                            )
                        );

                        $featureValues[$x] = array(
                            "feature_name" => $feature_name,
                            "feature_slug" => $_ScrapHelpers->sluggify($feature_name),
                            "feature_value_name" => $feature_value_name,
                            "feature_value_slug" => $_ScrapHelpers->sluggify($feature_value_name),
                        );



                        $featureValuesQuery = $QueryBuilder->insert(
                            $conn,
                            $options = array(
                                "table" => "feature_values",
                                "keys" => ["id","feature_value"],
                                "values" => [
                                    $_ScrapHelpers->sluggify($feature_value_name),
                                    $feature_value_name 
                                ]
                            )
                        );


                         $productFeaturesQuery = $QueryBuilder->insert(
                            $conn,
                            $options = array(
                                "table" => "product_features",
                                "keys" => ["product_id","feature_value_id","feature_id"],
                                "values" => [
                                    $productItem['id'],
                                    $_ScrapHelpers->sluggify($feature_value_name),
                                    $_ScrapHelpers->sluggify($feature_name)
                                ]
                            )
                        );
                     }

                 //var_dump($featureValues);    

                      
                }

            }

        }
  
        $QueryBuilder->closeConnection();
    }

  
}


?>