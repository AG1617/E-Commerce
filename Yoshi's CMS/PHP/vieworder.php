<?php
include('common.php');
output_navigation();     

// creating connection object
require '../vendor/autoload.php';

$mongo = (new MongoDB\Client);
$db=$mongo->ecommerce;
$collection=$db->order;

$cursor = $collection->find([]);


?>

<!-- View Order Table title-->
<div style = "font-size:30px; color:#b78846; position:absolute; left:20px; top:180px; ">
    View Order
  </div>

  

  <table id="viewproducts">
    <tr>
      <th style="background-color:#000000">Date</th>
      <th style="background-color:#000000">Order No.</th>
      <th style="background-color:#000000">Customer No.</th>
      <th style="background-color:#000000">Item Name</th>
      <th style="background-color:#000000">Item Cost</th>
      <th style="background-color:#000000">Item Count</th>
      <th style="background-color:#000000">Order Cost</th>
      <th style="background-color:#000000">Address</th>
    </tr>
  
  <!-- Table Contents-->
  
  <?php

  if(isset($_GET['func'])){
    $func = $_GET['func'];
    if ($func == "orders") {
      get_order();
    }

    
  }

  function get_order(){

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
  

    </table>
    
    <script src="http://localhost/CMS/js/order.js"></script>
    </body>
<?php
    
  
