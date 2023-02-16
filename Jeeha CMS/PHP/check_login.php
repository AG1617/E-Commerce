<!--Check the staff login credentials-->
<?php
    //Start session management
    session_start();

    //Get name and password from the input field
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);    

    //Connect to MongoDB 
    require __DIR__ .'/../vendor/autoload.php';

    $mongoClient = (new MongoDB\Client);

    //Select the ecommerce database
    $db = $mongoClient->Ecommerce;

     //Select the Staff collection
    $collection=$db->Staff;
    
    //Create a PHP array with our search criteria
    $findCriteria = [
        "Username" => $username, 
     ];

  
    //Find the staff that match the criteria
    $cursor = $collection->find($findCriteria)->toArray();


   

    foreach ($cursor as $user_matches){
        if ($user_matches['Password'] == $password){

            session_start();

            $_SESSION['loggedInStaffName'] = $user_matches['Username'];
            echo 'ok';
        }
    }
          
     

  
    