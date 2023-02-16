<?php

require '../vendor/autoload.php';

$mongo = (new MongoDB\Client);
$db=$mongo->ecommerce;
$collection=$db->product;

//$prodID= filter_input(INPUT_POST, 'prodID', FILTER_SANITIZE_STRING);
$Name = filter_input (INPUT_POST, 'Name', FILTER_SANITIZE_STRING) ;
$Description = filter_input (INPUT_POST, 'Description', FILTER_SANITIZE_STRING) ;
$Stock = filter_input (INPUT_POST, 'Stock', FILTER_SANITIZE_STRING) ;
$Price = filter_input (INPUT_POST, 'Price', FILTER_SANITIZE_STRING) ;
$ProductImage = filter_input (INPUT_POST, 'ProductImage', FILTER_SANITIZE_STRING) ;


//Convert to PHP array
$dataArray = [
//"prodID" => $prodID,
"Name" => $Name,
"Description" => $Description,
"Stock" => $Stock,
"Price" => $Price,
"ProductImage" => $ProductImage,

];
//Add the new product to the database
$insertResult = $collection->insertOne($dataArray);

//Echo result balk to user
if ($insertResult->getInsertedCount()==1){
    
    
    echo '<script>alert("New Product Added!!!!!")</script>';
    echo '<script>window.location.href="addprod.php"; </script>';
    //echo 'Customer added.';
    //echo ' New Product d:' . $insertResult->getInsertedId();
}
else {
    echo '<script>alert("Error Adding Product")</script>';
    //echo 'Error adding customer';

}

?>