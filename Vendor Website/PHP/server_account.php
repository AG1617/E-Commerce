<?php
    //Include libraries
    require '../vendor/autoload.php';
        
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->customer;

    session_start();

    

    if(isset($_GET['func'])){
        $func = $_GET['func'];
        if ($func == "account") {
            checklogin();
        }
    } else if (isset($_POST['func'])){
        $func = $_POST['func'];
        if ($func == "save") {
            save_details();
        } else if ($func == "username"){
            check_username();
        }

    }



    function checklogin(){
        global $collection;
        
        if ( array_key_exists('current_username', $_SESSION) ){
            $customer_id = $_SESSION['current_id'];

            $search_value = [
                "_id" => new MongoDB\BSON\ObjectID($customer_id)
            ];

            $cursor = $collection->find($search_value);

            $jsonStr = '[';

            foreach ($cursor as $user){
                $jsonStr .= json_encode($user);
                $jsonStr .= ',';
            }

            $jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

            $jsonStr .= ']';

            echo $jsonStr;

        }
    }

    function save_details(){
        global $collection;
        $customer_str = filter_input(INPUT_POST, 'customer_str');

        $dataArray = json_decode($customer_str, true);

        $id = $dataArray['id'];

        $replaceCriteria = [
            "_id" => new MongoDB\BSON\ObjectID($id)
        ];

        $newdata = [
            [ '$set' => ["username" => $dataArray['username']]],
            [ '$set' => ["address" => $dataArray['address']]],
            [ '$set' => ["password" => $dataArray['password']]]

        ];
        $search_username = [
            'username' => $dataArray['username']
        ];

        //Replace customer data for this ID
        $updateRes = $collection->updateOne($replaceCriteria, $newdata);

        if($updateRes->getModifiedCount() == 1){
            $cursor = $collection->find($search_username);
            foreach ($cursor as $user_matches){
                $_SESSION['current_username'] = $user_matches['username'];
                $_SESSION['current_id'] = $user_matches['_id'];
            }
            echo 'Customer document successfully replaced.';

        } else {
            echo 'Customer replacement error.';
        }
    }

    function check_username(){
        global $collection;

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $usernameArray = [
            "username" => $username
        ];

        //Find all of the customers that match  this criteria
        $cursor = $collection->find($usernameArray);
        foreach ($cursor as $cust){
            echo "true";
        }

    }


?>