<?php

    //Include libraries
    require '../vendor/autoload.php';
    
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->customer;

    //Get strings - need to filter input to reduce chances of SQL injection etc.
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $new_customer_str = filter_input(INPUT_POST, 'new_customer_str');


    //Convert to PHP array

    $usernameArray = [
        "username" => $username
    ];

    $dataArray = json_decode($new_customer_str, true);

    // function call
    if(isset($_POST['func'])){
        $func = $_POST['func'];
        if ($func == "username") {
            checkAvailability($usernameArray);
        } else {
            createUser($dataArray);
        }
    }
 
    function createUser($dataArray){
        global $collection;
        //Add the new user to the database
        $insertResult = $collection->insertOne($dataArray);

        // STORE REGISTRATION DATA IN MONGODB
        //Echo result back to user
        if($insertResult->getInsertedCount()!=1){
            echo '<script>alert("Error adding customer")</script>';
        }
    }

   function checkAvailability($array){
        global $collection;

        //Find all of the customers that match  this criteria
        $cursor = $collection->find($array);
        foreach ($cursor as $cust){
            echo "true";
        }    
    }