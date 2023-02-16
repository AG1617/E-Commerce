<?php    

require '../vendor/autoload.php';

$mongo = (new MongoDB\Client);
$db=$mongo->ecommerce;
$collection=$db->order;


  if(isset($_GET['func'])){
    $func = $_GET['func'];
    if ($func == "orders") {
      get_order();
    }
  }

  function get_order(){
    global $collection;

    $cursor = $collection->find([]);



    $jsonArray = '[';


    foreach ($cursor as $order) {
      $jsonArray .= json_encode($order);
      $jsonArray .= ',';
      
    }
    $jsonArray = substr($jsonArray, 0, strlen($jsonArray) -1);

    $jsonArray .= "]";

    echo $jsonArray;

  }

  ?>