<?php
include('common.php');
output_navigation();     
?>
<!-- form for user to add product to table from line 6-24 -->
<div class="form">
        <h2>Add product</h2>

    <form>
        <label for="prodID">Product ID:</label><br>
        <input type="text" id="prodID" name="prodID"><br>
        <label for="prodID">Name:</label><br>
        <input type="text" id="Name" name="Name"><br>
        <label for="prodID">Description:</label><br>
        <input type="text" id="Description" name="Description"><br>
        <label for="prodID">Price:</label><br>
        <input type="text" id="Price" name="Price"><br>
        <label for="prodID">Stock:</label><br>
        <input type="text" id="Stock" name="Stock"><br><br>
        <input type="submit" value="Add product">

    </form>

    </div>


</body>    
</html>