<?php

include('common.php');
output_navigation();    

// creating connection object
require '../vendor/autoload.php';

$mongo = (new MongoDB\Client);
$db=$mongo->ecommerce;
$collection=$db->product->find();

?>

<div style = "font-size:30px; color:#b78846; position:absolute; left:20px; top:180px; ">
        View Products
     </div>



<html> 
    <head>
    </head> 
<body> 
<table id="viewproducts">
        <tr>
          <th style="background-color:#000000">Product ID</th>
          <th style="background-color:#000000">Name</th>
          <th style="background-color:#000000">Description</th>
          <th style="background-color:#000000">Price</th>
          <th style="background-color:#000000">Stock Count</th>
      <!-- Table Contents-->
        </tr>
    

    <?php
        foreach ($collection as $row) {
    ?>
<tr> 
    <td><?php echo $row['_id'] ?></td>
    <td><?php echo $row['Name'] ?></td>
    <td><?php echo $row['Description'] ?></td>
    <td><?php echo $row['Price'] ?></td>
    <td><?php echo $row['Stock'] ?></td>
 </tr>
    <?php
    }
    ?>
    </table>
    </body>
<?php

