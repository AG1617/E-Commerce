<!--PHP form response on Edit product-->

<?php
//link the external php file
include('common.php');
output_navigation(); 

?>

<?php

//Include libraries
require __DIR__ . '/../vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select the ecommerce database
$db = $mongoClient->Ecommerce;

//Select the Products collection
$collection = $db->Product;

//Extract the id sent to the server
$id = filter_input(INPUT_POST,'prodID', FILTER_SANITIZE_STRING);

//Create a PHP array having the id that was sent to the server
$findCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($id)
];

//index creation required
//Find the single document that matched the
$cursor = $collection->find($findCriteria)->toArray();


   

    //display form to fill with the new details
    foreach ($cursor as $product){
        echo'<form id="editForm" action="updateprod.php" method="post">';
        echo'   <div class="form">';
        echo'       <h2>Edit product</h2>';
        echo'       <label for="name">Name:</label><br>';
        echo'       <input type="text" name="name" id="name" value="' . $product['Deck name'] . '"><br><br>';
        echo'       <label for="price">Price:</label><br>';
        echo'       <input type="text" name="price" id="price" value="' . $product['Price'] . '"><br><br>';
        echo'       <label for="desc">Description:</label><br>';
        echo'       <input type="text" name="desc" id="desc" value="' . $product['Deck edition'] . '"><br><br>';
        echo'       <label for="stock">Stock</label><br>';
        echo'       <input type="text" name="stock" id="stock" value="' . $product['Stock'] . '"><br><br>';
        echo'       <label for="stock">Image URL</label><br>';
        echo'       <input type="text" name="url" id="url" value="' . $product['Image path'] . '"><br><br>';
        echo'       <input type="hidden" name="productid" id="productid" value="' . $product['_id'] . '">';
        echo'       <input type="submit" value="Save">';
        echo'   </div>';
        echo'</form>';

    }
    



    