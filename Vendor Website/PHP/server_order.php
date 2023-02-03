<?php

    session_start();

    //Include libraries
    require '../vendor/autoload.php';
    
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->order;


    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "login") {
            checklogin();
        } else if ($func == "orders"){
            get_orders();

        }
    }

    function checklogin(){
        if ( array_key_exists('current_username', $_SESSION) ){
            $jsonStr = '[';
            $username = $_SESSION['current_username'];
            $jsonStr .= json_encode($username);
            $jsonStr .= ']';
            echo $jsonStr;
        }
    }

    function get_orders(){
        global $collection;

        $customer_id = $_SESSION['current_id'];

        $search_value = [
            "customer_id" => new MongoDB\BSON\ObjectID($customer_id)
        ];

        $cursor = $collection->find($search_value);

        $jsonArray = '[';

        foreach ($cursor as $order){
            $jsonArray .= json_encode($order);
            $jsonArray .= ',';
        }

        $jsonArray = substr($jsonArray, 0, strlen($jsonArray) - 1);

        $jsonArray .= ']';

        echo $jsonArray;

    }


?>