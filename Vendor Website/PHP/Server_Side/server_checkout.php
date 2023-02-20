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
    $collection1 = $db->order;
    $product_collection = $db->products;

    // function call based on command request from client
    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "login") {
            checklogin();
        } else if ($func == "current_id") {
            get_id();
        } else if ($func == "get_recommended") {
            get_recommended();
        }
    }

    
    // function call based on command request from client
    if(isset($_POST['func'])){
        $func = $_POST['func'];
        if ($func == "order") {
            new_order();
        }
    }

    // function which check is user details are present in 
    // php session, construct JSON array with details and send 
    // it back to client if yes
    function checklogin(){
        if ( array_key_exists('current_username', $_SESSION) ){
            $jsonStr = '[';
            $first_name = $_SESSION['first_name'];
            $last_name = $_SESSION['last_name'];
            $address = $_SESSION['address'];
            $jsonStr .= json_encode($first_name);
            $jsonStr .= ',';
            $jsonStr .= json_encode($last_name);
            $jsonStr .= ',';
            $jsonStr .= json_encode($address);
            $jsonStr .= ']';
            echo $jsonStr;
        }
    }

    // function which check is user details are present in 
    // php session, construct JSON array with details and send 
    // it back to client if yes
    function get_id(){

        if ( array_key_exists('current_username', $_SESSION) ){
            $jsonStr = '[';
            $customer_id = $_SESSION['current_id'];
            $address = $_SESSION['address'];
            $jsonStr .= json_encode($customer_id);
            $jsonStr .= ',';
            $jsonStr .= json_encode($address);
            $jsonStr .= ']';
            echo $jsonStr;
        }
    }

    // function which recieves a new order in JSON format from client
    // and decode it store it in the database
    function new_order(){

        global $collection1;
        global $product_collection;

        //Get strings - need to filter input to reduce chances of SQL injection etc.
        $new_order_str = filter_input(INPUT_POST, 'new_order_str');

        //converting JSON into PHP associative array
        $dataArray = json_decode($new_order_str, true);

        $customer_id = $dataArray['customer_id'];
        $product_arr = $dataArray['products'];

        //converting the object id's from JSON string to BSON format
        $object_id = new MongoDB\BSON\ObjectID($customer_id);
        $dataArray['customer_id'] = $object_id;

        //Add the new order to the database
        $insertResult = $collection1->insertOne($dataArray);

        //Echo result back to user
        if($insertResult->getInsertedCount()==1){

            //for each product bought by the customer
            //find product in product collection and update its stock level
            foreach ($product_arr as $product){

                $replaceCriteria = [
                    "deck_name" => $product['name']
                ];

                //find product
                $cursor = $product_collection->find($replaceCriteria);

                //get original stock level
                foreach ($cursor as $searched_product){
                    $original_stock = $searched_product['stock'];
                }

                $new_stock = $original_stock - $product['count'];

                $newdata = [
                    [ '$set' => ["stock" => $new_stock]]
                ];

                //update with new stock level
                $updateRes = $product_collection->updateOne($replaceCriteria, $newdata);

                //error message if update not successfull
                if($updateRes->getModifiedCount() != 1){

                    echo '<script>alert("Error updating stock")</script>';

                }
            }

            //error message if new order insertion not successfull
        } else 
        {
            echo '<script>alert("Error adding order")</script>';
        }
    }


    // function which get the customer's most search keyword and finds 
    // all the products which match it based on a search on their index
    function get_recommended(){

        global $product_collection;

        //Get strings - need to filter input to reduce chances of SQL injection etc.
        $search_value = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);

        // check if keyword is null, if yes
        // return all products in ascending order in JSON format,
        // else return search results in JSON fromat
        if ($search_value != ""){

            //converting search criteria in PHP array
            $search_criteria = [

                '$text' => [ '$search' => $search_value ]
            ];
    
            //Find all of the orders that match  this criteria
            $cursor = $product_collection->find($search_criteria);
    
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
    

        } else {

            //ascending order format
            $options = ['sort' => ['price' => 1]];

            $cursor = $product_collection->find([],$options);

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

       
        


    }


?>