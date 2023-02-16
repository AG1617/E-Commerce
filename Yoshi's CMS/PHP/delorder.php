<?php
    // creating connection object
    require '../vendor/autoload.php';

    $mongo = (new MongoDB\Client);
    $db = $mongo->ecommerce;
    
    //input in deleteorder.php 
    $id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_STRING);

    
    //ID w
    $deleteCriteria = [
        "_id" => new MongoDB\BSON\ObjectID($id)
    ];

    $deleteResult = $db->order->deleteOne($deleteCriteria);

    if ($deleteResult->getDeletedCount() == 1){
        echo '<script>alert("Has been Deleted !!!!!")</script>';
    } else {
        echo '<script>alert("Has not been Deleted !!!!!")</script>';
    }

?>