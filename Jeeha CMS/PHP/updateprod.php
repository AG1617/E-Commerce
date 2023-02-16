<?php
//link the external php file
include('common.php');
output_navigation();

//MongoDB
//Include libraries
require __DIR__ . '/../vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select the ecommerce database
$db = $mongoClient->Ecommerce;


//Extract the product details from the edit form
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
$stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING);
$img = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
$id= filter_input(INPUT_POST, 'productid', FILTER_SANITIZE_STRING);

//Criteria for finding document to replace : Hold the id
$replaceCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($id)
];

//Data replacement
$productData = [
    "Deck name" => $name,
    "Price" => (int)$price,
    "Deck edition" => $description,
    "Stock" => (int)$stock,
    "Image path" => $img     
];

//Replace customer data for this ID
$updateRes = $db->Product->replaceOne($replaceCriteria, $productData);
    
//Echo result back to user
if($updateRes->getModifiedCount() == 1)
    echo '<div style="color:white;margin-left:10px;margin-top:20px;font-size:20px;">Product document successfully replaced.</div>';
else
    echo '<div style="color:white;margin-left:10px;margin-top:20px;font-size:20px;">Product replacement error.</div>';