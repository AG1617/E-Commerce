<?php

    session_start();

    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "login") {
            checklogin();
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


?>