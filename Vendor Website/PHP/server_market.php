<?php

    //Include libraries
    require '../vendor/autoload.php';
        
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->products;

    $collection->createIndex(['keywords' => "text"]);

    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "search") {
            search_index();
        }
    }

    function display_products(){
        global $collection;

        $cursor = $collection->find([]);

        foreach ($cursor as $product){
            if ($product['stock'] > 0){

                echo '<li>';
                echo '<img src="' . $product['image_path'] . '"alt="' . $product['deck_name'] . '">';
                echo '<h2>' . $product['deck_name'] . '</h2>';
                echo '<h3>' . $product['edition'] . '</h3>';
                echo '<p>' . $product['price'] . '</p>';
                echo '<p><button class="addcart">Add to Cart</button></p>';
                echo '</li>';

            }
        }
    }

    function search_index(){
        global $collection;

        $search_value = filter_input(INPUT_GET, 'search_value', FILTER_SANITIZE_STRING);

        $search_criteria = [

            '$text' => [ '$search' => $search_value ]
        ];

        $cursor = $collection->find($search_criteria);

        $jsonStr = '[';

        foreach ($cursor as $result){
            $jsonStr .= json_encode($result);
            $jsonStr .= ',';
        }

        $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

        $jsonStr .= ']';

        echo $jsonStr;

    }



?>