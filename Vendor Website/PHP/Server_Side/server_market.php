<?php

    //Start session management
    session_start();
    
    //Include libraries
    require '../vendor/autoload.php';
        
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->products;
    $order_collection = $db->order;

    //set which fields is to be used as index
    $collection->createIndex(['keywords' => "text"]);

    // function call based on command request from client
    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "search") {
            search_index();
        } else if ($func == "searchAndOrder") {
            search_and_sort();
        } else if ($func == "Order") {
            sort_prod();
        } else if ($func == "get_orders") {
            return_orders_json();
        } else if ($func == "get_prods") {
            return_products_json();
        }
    }

    //fucntion to contruct HTML code based on product data which was pulled from server and
    // display on page
    function display_products(){
        global $collection;

        //get all products from the database
        $cursor = $collection->find([]);

        //select only products which have a stock level greater than 0
        foreach ($cursor as $product){
            if ($product['stock'] > 0){

                //echo the HTML code directly onto the page
                echo '<li>';
                echo '<img src="' . $product['image_path'] . '"alt="' . $product['deck_name'] . '">';
                echo '<h2>' . $product['deck_name'] . '</h2>';
                echo '<h3>' . $product['edition'] . '</h3>';
                echo '<h3> In Stock : ' . $product['stock'] . '</h3>';
                echo '<p>Rs ' . $product['price'] . '</p>';
                echo '<p><button onclick=\'add_to_cart("' . $product["_id"] . '","' . $product["deck_name"] 
                . '","' . $product["price"] . '","' . $product["edition"] .  '","' . $product["stock"] . '","' 
                . $product["image_path"] .'", this)\' class="addcart">Add to Cart</button></p>';
                echo '</li>';

            }
        }
    }

    //fucntion to get search keyword from client and perform search operation
    //in keywords field from database return a JSON array of products matching 
    // search criteria
    function search_index(){

        global $collection;

        //Get searchTxt strings - need to filter input to reduce chances of SQL injection etc.
        $search_value = filter_input(INPUT_GET, 'search_value', FILTER_SANITIZE_STRING);

        //Create a PHP array for session criteria
        $search_criteria = [

            '$text' => [ '$search' => $search_value ]
        ];

        //Find all of the orders that match  this criteria
        $cursor = $collection->find($search_criteria);

        //Start of array of orders in JSON
        $jsonStr = '[';

        // Output each orders as a JSON object with comma in between
        foreach ($cursor as $result){
            $jsonStr .= json_encode($result);
            $jsonStr .= ',';
        }

        //Remove last comma
        $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

        //Close array
        $jsonStr .= ']';

        // Echo final string
        echo $jsonStr;

    }

    //function to search product by keyword and sort results by price depending on command from client
    //sends back a JSON array of objects
    function search_and_sort(){

        global $collection;

        //Get searchTxt strings - need to filter input to reduce chances of SQL injection etc.
        $search_value = filter_input(INPUT_GET, 'search_value', FILTER_SANITIZE_STRING);

        $sort_value = filter_input(INPUT_GET, 'sort_value', FILTER_SANITIZE_STRING);

        //Create a PHP array for session criteria
        $search_criteria = [

            '$text' => [ '$search' => $search_value ]
        ];

        //select code to run based on sorting criteria
        if ( $sort_value == "ascending"){

            //option for ascending sort
            $options = ['sort' => ['price' => 1]];

            //Find all of the products that match this criteria
            $cursor = $collection->find($search_criteria,$options);
            
        } else if ($sort_value == "descending") {

            //option for descending sort
            $options = ['sort' => ['price' => -1]];

            //Find all of the products that match this criteria
            $cursor = $collection->find($search_criteria,$options);
        }

        //Start of array of orders in JSON
        $jsonStr = '[';

        // Output each orders as a JSON object with comma in between
        foreach ($cursor as $result){
            $jsonStr .= json_encode($result);
            $jsonStr .= ',';
        }

        //Remove last comma
        $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

        //Close array
        $jsonStr .= ']';

        // Echo final string
        echo $jsonStr;



    }

    //function sort all products and return a JSON array of object based on command from client
    function sort_prod(){

        global $collection;

        //Get searchTxt strings - need to filter input to reduce chances of SQL injection etc.
        $sort_value = filter_input(INPUT_GET, 'sort_value', FILTER_SANITIZE_STRING);

        //select code to run based on sorting criteria
        if ( $sort_value == "ascending"){

            $options = ['sort' => ['price' => 1]];

            //Find all of the products that match this criteria
            $cursor = $collection->find([],$options);
            
        } else if ($sort_value == "descending") {

            $options = ['sort' => ['price' => -1]];

            //Find all of the products that match this criteria
            $cursor = $collection->find([],$options);

        } else {

            //if sorting is default only get all products in no particular order
            $cursor = $collection->find([]);

        }

        //Start of array of orders in JSON
        $jsonStr = '[';

        // Output each orders as a JSON object with comma in between
        foreach ($cursor as $result){
            $jsonStr .= json_encode($result);
            $jsonStr .= ',';
        }

        //Remove last comma
        $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

        $jsonStr .= ']';

        // Echo final string
        echo $jsonStr;

    }

    // fucntion to return a JSON array of object contaning all the past
    //orders of currently logged in user
    function return_orders_json(){

        global $order_collection;

        //check if user is logged in
         if ( array_key_exists('current_id', $_SESSION) ){

            //if yes get the customer id
            $customer_id = $_SESSION['current_id'];
         }

         
        //Create a PHP array with our search criteria
        $search_value = [
            "customer_id" => new MongoDB\BSON\ObjectID($customer_id)
        ];

        //Find all of the products that match this criteria
        $cursor = $order_collection->find($search_value);

        $jsonArray = '[';

        // Output each orders as a JSON object with comma in between
        foreach ($cursor as $order){
            $jsonArray .= json_encode($order);
            $jsonArray .= ',';
        }

        //Remove last comma
        $jsonArray = substr($jsonArray, 0, strlen($jsonArray) - 1);

        $jsonArray .= ']';

        // Echo final string
        echo $jsonArray;
    }


    // fucntion to return a JSON array of objects of products 
    // which have a current stock level greater than zero
    function return_products_json(){

        global $collection;

        //Find all of the products that match this criteria
        $cursor = $collection->find([]);

        $jsonStr = '[';

        // Output each product as a JSON object with comma in between
        foreach ($cursor as $product){

            if($product['stock'] > 0)
            {
                $jsonStr .= json_encode($product);
                $jsonStr .= ',';
            }


        }

        //Remove last comma
        $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

        $jsonStr .= ']';

        // Echo final string
        echo $jsonStr;

    }



?>