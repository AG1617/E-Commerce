<?php

//require __DIR__ .'/vendor /autoload.php';
require '../vendor/autoload.php';

$mongo = (new MongoDB\Client);
$db=$mongo->ecommerce;
$collection=$db->product;

if($_POST)
{
$insert = array(
'prodID' => $_POST['prodID'],
'Name' => $_POST['Name'],
'Description' => $_POST['Description'],
'Price' => $_POST['Price'],
'Stock' => $_POST['Stock'],
    );

    if($collection->insert($insert));
    {
        echo '<script>alert("Data has been added")</script>';
    }

}


?>