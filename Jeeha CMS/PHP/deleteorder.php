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

<!-- form to input id of order to be removed from line 6-17 -->
<div class="form">
        <h2>Delete order</h2>


    <form>
        <label for="orderID">Order ID:</label><br>
        <input type="text" id="orderID" name="orderID"><br><br>
        <input type="submit" value="Delete">

    </form>

    </div>


</body>    
</html>