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


<!-- Input boxes for user to input product id from line 6-14 -->
<div class="form">
        <h2>Edit product</h2>

    <form action="editform.php" method="post">
        <label for="prodID">Product ID:</label><br>
        <div class="float">
            <input type="text" id="prodID" name="prodID">
            <input type="submit" value="Get">
        </div><br>


        </div>
        

    </form>

    </div>


</body>    
</html>