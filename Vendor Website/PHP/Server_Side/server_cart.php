<?php

    //Start session management
    session_start();

    // function call based on command request from client
    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "getLogin") {
            checklogin();
        }
    }

    // function which check is user details are present in 
    // php session, construct JSON array with details and send 
    // it back to client if yes
    function checklogin(){

        if ( array_key_exists('current_username', $_SESSION) ){
            
            //if found construct JSON string and echo it back to client
            $jsonStr = '[';
            $username = $_SESSION['current_username'];
            $id = $_SESSION['current_id'];
            $jsonStr .= json_encode($username);
            $jsonStr .= ',';
            $jsonStr .= json_encode($id);
            $jsonStr .= ']';
            echo $jsonStr;

        }
    }


?>