<?php
include('common.php');
output_navigation();     
?>

<?php

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

if(!isset($_SESSION["loggedInStaffName"]) || empty($_SESSION["loggedInStaffName"])){
  header('Location: index.php?auth=1');  
}

?>


<!-- View Order Table title-->
<div style = "font-size:30px; color:#b78846; position:absolute; left:20px; top:180px; ">
    View Order
  </div>

  <table id="viewproducts">
    <tr>
      <th style="background-color:#000000">Date</th>
      <th style="background-color:#000000">Order No.</th>
      <th style="background-color:#000000">Item Name</th>
      <th style="background-color:#000000">Item Cost</th>
      <th style="background-color:#000000">Order Cost</th>
      <th style="background-color:#000000">Delivery Address</th>
  
  <!-- Table Contents-->
    </tr>
    <tr>
      <td>15/01/2023</td>
      <td>23480</td>
      <td>Marvel's Official Spiderman playing Card</td>
      <td>Rs 450</td>
      <td>Rs 1300</td>
      <td>Royal Road, Curepipe</td>
  
    </tr>
    <tr>
      <td>15/01/2023</td>
      <td>23390</td>
      <td>Knights Deck</td>
      <td>Rs 450</td>
      <td>Rs 1400</td>
      <td>Royal Road, Rose-Hill</td>
    </tr>
    <tr>
      <td>12/01/2023</td>
      <td>18790</td>
      <td>Ellusionist Deck: Black Anniversary Edition</td>
      <td>Rs 490</td>
      <td>Rs 490</td>
      <td>Coastal Road, Flic-En-Flac</td>
    </tr>
  
    <tr>
      <td>19/01/2023</td>
      <td>17800</td>
      <td>Nostalgic back design</td>
      <td>Rs 750</td>
      <td>Rs1500</td>
      <td>Chapel Lane, Rose-Belle</td>
    </tr>
  
    <tr>
      <td>01/01/2023</td>
      <td>14308</td>
      <td>Red Cohorts feel as good as they perform.</td>
      <td>Rs 500</td>
      <td>Rs1000</td>
      <td>Beach Lane, Pereybere</td>
    </tr>
    <tr>
      <td>03/01/2023</td>
      <td>12982</td>
      <td>This vintage casino-style deck was designed with simplicity in mind.</td>
      <td>Rs 590</td>
      <td>Rs 590</td>
      <td>Blackberry street, wooton</td>
    </tr>
    <td>03/01/2023</td>
      <td>18361</td>
      <td>The Discord Deck is a celebration of those common ideas coming together to form an alliance. A community. </td>
      <td>Rs 450</td>
      <td>Rs900</td>
      <td>Pierre-Poive street, Port-Louis</td>
    </tr>
    <tr>
      <td>04/01/2023</td>
      <td>87293</td>
      <td>Black Tigers are that break in the pattern. A black deck of cards in a sea of white paper. </td>
      <td>Rs 750</td>
      <td>Rs1500</td>
      <td>Gibson Road, Floreal</td>
    </tr>
  
    <td>04/01/2023</td>
    <td>23848</td>
    <td> In 1957, 26 swarms escaped quarantine and declared war on the western hemisphere.</td>
    <td>Rs 750</td>
    <td>750</td>
    <td>Royal Road, Quatre-Bornes</td>
  </tr>
    
  
  </table>
  
    </style>


</body>    
</html>