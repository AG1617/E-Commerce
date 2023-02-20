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
    $collection = $db->order;


    // function call based on command request from client
    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "login") {
            checklogin();
        } else if ($func == "orders"){
            get_orders();

        }
    }

    //fucntion to check if current user data exits in PHP session
    function checklogin(){
        if ( array_key_exists('current_username', $_SESSION) ){
            
            //if exists, a JSON string array containing user details is created and sent back to client
            $jsonStr = '[';
            $username = $_SESSION['current_username'];
            $jsonStr .= json_encode($username);
            $jsonStr .= ']';
            echo $jsonStr;
        }
    }

    //function to get all past orders of specific user from database and
    //return it to client in JSON format
    function get_orders(){
        global $collection;

        //get current user if from session
        $customer_id = $_SESSION['current_id'];

        //Create a PHP array with our search criteria
        $search_value = [
            "customer_id" => new MongoDB\BSON\ObjectID($customer_id)
        ];

        //Find all of the orders that match  this criteria
        $cursor = $collection->find($search_value);

        //Start of array of orders in JSON
        $jsonArray = '[';

        // Output each orders as a JSON object with comma in between
        foreach ($cursor as $order){

            //Convert PHP representation of order into JSON
            $jsonArray .= json_encode($order);
            $jsonArray .= ',';
        }

        //Remove last comma
        $jsonArray = substr($jsonArray, 0, strlen($jsonArray) - 1);

        //Close array
        $jsonArray .= ']';

        // Echo final string
        echo $jsonArray;

    }


?>