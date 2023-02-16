<?php

    require '../vendor/autoload.php';

    $mongo = (new MongoDB\Client);
    $db = $mongo->ecommerce;
    
    $id = filter_input(INPUT_POST, 'product_ID', FILTER_SANITIZE_STRING);


    $deleteCriteria = [
        "_id" => new MongoDB\BSON\ObjectID($id)
    ];

    $deleteResult = $db->product->deleteOne($deleteCriteria);

    if ($deleteResult->getDeletedCount() == 1){
        echo '<script>alert("Has been Deleted !!!!!")</script>';
    } else {
        echo '<script>alert("Has not been Deleted !!!!!")</script>';
    }
    echo '<script>window.location.href="delete.php"; </script>';

?>