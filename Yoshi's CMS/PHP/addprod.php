<?php
include('common.php');
output_navigation();     
?>
<!-- form for user to add product to table from line 6-24 -->
<div class="form">
    
        <h2>Add product</h2>

    <form action = "insert1.php" method = "post">

        
        <label for="prodID">Name:</label><br>
        <input type="text" id="Name" name="Name"><br><br>

        <label for="prodID">Description:</label><br>
        <input type="text" id="Description" name="Description"><br><br>

        <label for="prodID">Price:</label><br>
        <input type="text" id="Price" name="Price"><br><br>

        <label for="prodID">Stock:</label><br>
        <input type="text" id="Stock" name="Stock"><br><br>

        <label for="prodID">Product Image:</label><br>
        <input type="text" id="ProductImage" name="ProductImage"><br><br>

        <input  type="submit" value="Add product">
       

    </form>

    </div>


</body>    
</html>