<?php
include('common.php');
output_navigation();     
?>
<!-- Input boxes for user to input product id from line 6-14 -->
<div class="form">
        <h2>Edit product</h2>

    <form>
        <label for="prodID">Product ID:</label><br>
        <div class="float">
            <input type="text" id="prodID" name="prodID" placeholder="63c3a6f2bbcb9181e3db05ff">
            <input type="submit" value="Get">
        </div><br>
        <!-- Dummy data about details for product that was fetched from line 16-25 -->
        <div class="getprod">
            <label for="name">Name:</label><br>
            <input type="text" id="name" placeholder="Knights V2"><br><br>
            <label for="price">Price:</label><br>
            <input type="text" id="price" placeholder="441.36"><br><br>
            <label for="desc">Description:</label><br>
            <input type="text" id="desc" placeholder="Luxury-pressed E7"><br><br>
            <label for="stock">Stock</label><br>
            <input type="text" id="stock" placeholder="5"><br><br>
            <input type="submit" value="Save">


        </div>
        

    </form>

    </div>


</body>    
</html>