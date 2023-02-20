<?php
    //Include libraries
    require '../vendor/autoload.php';
        
    //Create instance of MongoDB client
    $mongoClient = (new MongoDB\Client);

    //Select a database
    $db = $mongoClient->vendor;

    //Select a collection 
    $collection = $db->customer;

    //Start session management
    session_start();

    

    // function call based on command request from client
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


    // function which checks is user details are present in 
    // php session, construct JSON array with details and send 
    // it back to client if yes
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

    // function which recievs all new account details from client 
    // constructs a PHP array with new data and uses it to update 
    // account data in database
    function save_details(){

        global $collection;

        //Get searchTxt strings - need to filter input to reduce chances of SQL injection etc.
        $customer_str = filter_input(INPUT_POST, 'customer_str');

        //converting JSON into PHP associative array
        $dataArray = json_decode($customer_str, true);

        $id = $dataArray['id'];

        //converting the object id's from JSON string to BSON format
        $replaceCriteria = [
            "_id" => new MongoDB\BSON\ObjectID($id)
        ];

        //setting new data which will replace original in database
        $newdata = [
            [ '$set' => ["username" => $dataArray['username']]],
            [ '$set' => ["address" => $dataArray['address']]],
            [ '$set' => ["password" => $dataArray['password']]]

        ];

        //search criteria to find correct customer
        $search_username = [
            'username' => $dataArray['username']
        ];

        //Replace customer data for this ID
        $updateRes = $collection->updateOne($replaceCriteria, $newdata);

        //check if update operation is successfull
        //update user data in PHP session
        //outputs error messages where needed
        if($updateRes->getModifiedCount() == 1){
            $cursor = $collection->find($search_username);
            foreach ($cursor as $user_matches){
                $_SESSION['current_username'] = $user_matches['username'];
                $_SESSION['current_id'] = $user_matches['_id'];
                $_SESSION['address'] = $user_matches['address'];
            }
            echo 'Customer document successfully replaced.';

        } else {
            echo 'Customer replacement error.';
        }
    }

    //function which checks if username recieved from client is 
    //unique or not
    function check_username(){
        global $collection;

        //Get searchTxt strings - need to filter input to reduce chances of SQL injection etc.
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

        //search criteria to find correct customer
        $usernameArray = [
            "username" => $username
        ];

        //Find all of the customers that match  this criteria
        $cursor = $collection->find($usernameArray);

        //if not unique
        foreach ($cursor as $cust){
            echo "true";
        }

    }


?>