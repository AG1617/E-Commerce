<?php
include('common.php');
output_navigation();     
?>

<!-- form to input id of product to be removed from line 7-16 -->
<div class="form">
        <h2>Delete product</h2>


    <form action="delete.php" method="post">
    
        <label for="prodID">Object ID:</label><br>
        <input type="text" id="ProdID" name="product_ID"><br><br>
        <input type="submit" value="Delete">

    </form>

    </div>


</body>    
</html>