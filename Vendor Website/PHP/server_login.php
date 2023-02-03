<?php

    //Include libraries
    require '../vendor/autoload.php';
    
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->customer;

    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    

    $search_value = [
        'username' => $username
    ];

    $cursor = $collection->find($search_value);

    foreach ($cursor as $user_matches){
        if ($user_matches['password'] == $password){

            session_start();

            $_SESSION['current_username'] = $user_matches['username'];
            $_SESSION['current_id'] = $user_matches['_id'];

            echo 'ok';
        }
    }
    