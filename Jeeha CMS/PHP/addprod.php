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

<!-- form for user to add product to table from line 6-24 -->
<div class="form">
        <h2>Add product</h2>

    <form>
        <label for="prodID">Product ID:</label><br>
        <input type="text" id="prodID" name="prodID"><br><br>
        <label for="prodID">Name:</label><br>
        <input type="text" id="Name" name="Name"><br><br>
        <label for="prodID">Description:</label><br>
        <input type="text" id="Description" name="Description"><br><br>
        <label for="prodID">Price:</label><br>
        <input type="text" id="Price" name="Price"><br><br>
        <label for="prodID">Stock:</label><br>
        <input type="text" id="Stock" name="Stock"><br><br>
        <input type="submit" value="Add product">

    </form>

    </div>


</body>    
</html>