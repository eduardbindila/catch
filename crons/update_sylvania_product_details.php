<?php 
//error_reporting(E_ALL); ini_set('display_errors', 1); 

require_once($_SERVER['DOCUMENT_ROOT'].'/config/helpers.php');
require_once($_PATH['COMMON_BACKEND'].'functions.php');

$root = "https://www.sylvania-lighting.com/product/en-int/products/";




    $conn = $QueryBuilder->dbConnection();

    $productQuery = $QueryBuilder->select(
        $conn,
        $options = array(
            "table" => "products",
            "columns" => "id",
            "where" => "is_b2c = 1 AND last_crawled_date <= CURRENT_DATE()",
            //"where" => "manufacturer ='syl' AND last_crawled_date <= CURRENT_DATE() - INTERVAL 1 MONTH",
            "orderBy" => "last_crawled_date",
            "orderType" => "ASC",
            "limit" => "20"

        ),
        $returnType = 'insertedProducts'

    );

    $QueryBuilder->closeConnection();

$product_array = array(
        "data" => array(),
    );

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

        function getURLfromBg($bg) {
            $bgImage = explode('(', $bg);
            $bgImage = explode(')', $bgImage[1])[0];
            return $bgImage;
        } 
    }

    $_ScrapHelpers = new ScrapHelpers();

    function dd($data){
        highlight_string("<?php\n " . var_export($data, true) . "?>");
      echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
      die();
    }

    printError($productQuery);

foreach ($productQuery as $key => $value) {
    # code...

    //$key = '0029106';

    $html = file_get_contents($root.$key.'/');

    $crawling_status = strpos($http_response_header[0], "200") ? 1 : $http_response_header[0];

    // echo $http_response_header[0];

    if($crawling_status == 1) {

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $product_description_class = "product-overview__copy";
        $product_image_class = "product-overview__image";
        $product_title_class = "intro-block__title";
        $product_infopanels_class = "info-panels";
        $product_table_class = "info-panels";
        $energy_label_image_class = "EnergyLabelContainer";
        $energy_label_link_class = "info-panels__link";
        $product_data_section_id = "tab-product-data-table";
        $breadcrumbData = $dom->saveHTML($xpath->query('//div[contains(@class,"breadcrumb")]')[0]);
        $breadcrumbRaw = $xpath->query('//div[contains(@class,"breadcrumb")]/div')[0];


        // $category_path = $xpath->query('//div[@class="'.$product_description.'"]');

        $product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

        $product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

        $product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

        $product_infopanels = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

        $product_data = $xpath->query('//section[contains(@id,"'.$product_data_section_id.'")]');

        $energy_label = $xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")] //a[@data-modal-caption="EU"]')->length;




        $breadcrumb = explode("\r\n", $breadcrumbRaw->nodeValue);

        $breadcrumbArray = array_splice($breadcrumb, 3, -2);
        
        $categoryId = "";

        $breadcrumbIndex = 0;  

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

        $this_product = array(
                "product_name" => trim($product_title),
                "product_id" => $key,
                "product_description" => addslashes(htmlspecialchars($product_description)),
                "product_image" => $product_image,
                "parent_id" => $categoryId,
                "product_diagrams" => addslashes(htmlspecialchars($product_infopanels)),
                "energy_label" => $energy_label
        );

        //printError($this_product);

        foreach ($product_data as $keyf => $valuef) {
            

            $table = $valuef->getElementsByTagName('table');

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
                                    $key,
                                    $_ScrapHelpers->sluggify($feature_value_name),
                                    $_ScrapHelpers->sluggify($feature_name)
                                ]
                            )
                        );
                     }

                 //printError($featureValues);    

                      
                }

            }
        }
        
        $updateQuery = $QueryBuilder->update(
            $conn,
            $options = array(
                "table" => "products",
                "set" => [
                    "`product_name`='".$this_product['product_name']."'",
                    "`product_description`='".$this_product['product_description']."'",
                    "`product_image`='".$this_product['product_image']."'",
                    "`product_diagrams`='".$this_product['product_diagrams']."'",
                    "`parent_id`='".$this_product['parent_id']."'",
                    "`last_crawled_date`=NOW()",
                    "`last_crawled_status`='".$crawling_status."'",
                    "`has_energy_label`='".$this_product['energy_label']."'"   
                ],
                "where" => "id='".$this_product['product_id']."'"
            )
        );

        //var_dump($updateQuery);

        if($updateQuery == 0) {
            $crawling_status = 0;

            $updateStatus = $QueryBuilder->update(
                $conn,
                $options = array(
                    "table" => "products",
                    "set" => [
                        "`last_crawled_date`=NOW()",
                        "`last_crawled_status`='".$crawling_status."'"   
                    ],
                    "where" => "id='".$this_product['product_id']." '"
                )
            );
        } 

    } else {

        //var_dump($this_product);

        $updateStatus = $QueryBuilder->update(
                $conn,
                $options = array(
                    "table" => "products",
                    "set" => [
                        "`last_crawled_date`=NOW()",
                        "`last_crawled_status`=0"   
                    ],
                    "where" => "id = '".$key."'"
                )
            );
         
    }

    echo "\n".$key.' - '.$crawling_status;
}






//     $product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

//     $product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

//     $product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

//     $product_infopanels_class = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

//     print_r($product_title);

//     print_r($product_description);

//     print_r($product_infopanels_class);
 
	
?>