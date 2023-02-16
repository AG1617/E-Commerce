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

<!-- form to input id of product to be removed from line 7-16 -->
<div class="form">
        <h2>Delete product</h2>


    <form>
        <label for="prodID">Product ID:</label><br>
        <input type="text" id="prodID" name="prodID"><br><br>
        <input type="submit" value="Delete">

    </form>

    </div>


</body>    
</html>