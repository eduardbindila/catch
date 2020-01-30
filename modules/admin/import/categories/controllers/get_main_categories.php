<?php 
error_reporting(E_ALL); ini_set('display_errors', 1); 

$root = "https://www.sylvania-lighting.com";

$categories_url = $root."/product/en-int/categories/";

    $html = file_get_contents($categories_url);
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $category_array = array(
        "data" => array(),
    );


    CLASS ScrapHelpers {

        function sluggify($s){
            $removeSlashes = str_replace('/', '_', $s);
            return strtolower(str_replace(' ', '_', $removeSlashes));
        }

        function getURLfromBg($bg) {
            $bgImage = explode('(', $bg);
            $bgImage = explode(')', $bgImage[1])[0];
            return $bgImage;
        } 
    }

    $_ScrapHelpers = new ScrapHelpers();



    //========= XPATH CLASSES ==========
    $main_category_class = "product-grid__item col col-6";
    $main_category = $xpath->query('//div[@class="'.$main_category_class.'"]');


    foreach ($main_category as $category_index => $value) {

        //========= NODE NAVIGATION HELPERS ==========
        $main_category_wrapper = $value->childNodes[1];
        $main_category_info = $main_category_wrapper->childNodes[1];
        $bgImage = $main_category_info->childNodes[1]->attributes[1]->textContent;


        //========= ARRAY VARS ==========
        $main_category_image = $_ScrapHelpers->getURLfromBg($bgImage);
        $main_category_name = trim($main_category_info->childNodes[3]->textContent);
        $main_category_url = $main_category_wrapper->attributes[1]->textContent;
        $main_category_slug = $_ScrapHelpers->sluggify($main_category_name);

		$main_category_array = array(
			"category_slug" => $main_category_slug,
			"category_name" => $main_category_name,
			"category_image" => $main_category_image,
			"category_url" => $main_category_url,
            "parent_slug" => NULL
	    );

 		array_push($category_array['data'], $main_category_array);
	}

	echo json_encode($category_array);
?>