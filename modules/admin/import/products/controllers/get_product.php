<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

$root = "https://www.sylvania-lighting.com/product/en-int/products/";

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



$html = file_get_contents($root.$_GET['product_id'].'/');
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$product_description_class = "product-overview__copy";
$product_image_class = "product-overview__image";
$product_title_class = "intro-block__title";
$product_infopanels_class = "info-panels";
$product_table_class = "info-panels";
$product_data_section_id = "tab-product-data-table";

// $category_path = $xpath->query('//div[@class="'.$product_description.'"]');

$product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

$product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

$product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

$product_infopanels = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

$product_data = $xpath->query('//section[contains(@id,"'.$product_data_section_id.'")]');

$this_product = array(
        "product_name" => trim($product_title),
        "product_id" => $_GET['product_id'],
        "product_description" => htmlspecialchars($product_description),
        "product_image" => $product_image,
        "product_infopanels" => htmlspecialchars($product_infopanels),
        "features_list" => array(),
        //"parent_id" => $_POST['parent_id']
);



//echo sizeof($product_data);

$features = array();


foreach ($product_data as $key => $value) {
    

    $table = $value->getElementsByTagName('table');

    foreach($table as $k => $val) {

        $feature_category = $val->getElementsByTagName('thead')[0]->textContent;

        $feature_category_name = trim($feature_category);

        $features[$k] = array(
            'feature_category' => array(
                'feature_category_name' => $feature_category_name,
                'feature_category_slug' => $_ScrapHelpers->sluggify($feature_category_name)
            ),

            "features" => ""
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

                $features_array[$x] = array(
                    "feature_name" => $feature_name,
                    "feature_slug" => $_ScrapHelpers->sluggify($feature_name),
                    "feature_value_name" => $feature_value_name,
                    "feature_value_slug" => $_ScrapHelpers->sluggify($feature_value_name),
                );
             }

             $features[$k]['features'] = $features_array; 

              
        }

        // $feature = $td[0]->textContent;

        // $feature_value = $td[1]->textContent;
    }

    $this_product['features_list'] = $features;
}

array_push($product_array['data'], $this_product);

echo json_encode($product_array);



//     $product_image = $xpath->query('//div[contains(@class,"'.$product_image_class.'")]/img')[0]->getAttribute('src');

//     $product_title = $xpath->query('//h1[contains(@class,"'.$product_title_class.'")]')[0]->nodeValue;

//     $product_description = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_description_class.'")]')[0]);

//     $product_infopanels_class = $dom->saveHTML($xpath->query('//div[contains(@class,"'.$product_infopanels_class.'")]')[0]);

//     print_r($product_title);

//     print_r($product_description);

//     print_r($product_infopanels_class);
 
	
?>