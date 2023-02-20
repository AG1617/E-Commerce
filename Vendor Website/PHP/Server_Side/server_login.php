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
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    

    //Convert to PHP array
    $search_value = [
        'username' => $username
    ];

    //Find all of the customers that match this criteria
    $cursor = $collection->find($search_value);

    // check if username and password match for account authentication
    foreach ($cursor as $user_matches){
        if ($user_matches['password'] == $password){

            //Start session management
            session_start();

            //store all user details in PHP session
            $_SESSION['current_username'] = $user_matches['username'];
            $_SESSION['current_id'] = $user_matches['_id'];
            $_SESSION['first_name'] = $user_matches['first_name'];
            $_SESSION['last_name'] = $user_matches['last_name'];
            $_SESSION['address'] = $user_matches['address'];

            //echo confirmation message
            echo 'ok';
        }
    }
    