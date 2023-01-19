<?php
include('common.php');
output_navigation();     
?>

<div class="form">
        <h2>View Order</h2>

    <form>
        <label for="orderID">Order ID:</label><br>
        <div class="float">
            <input type="text" id="orderID" name="orderID" placeholder="63c3a6f2bbcb9181e3db05ff">
            <input type="submit" value="Get">
        </div><br>

        <div class="getprod">
            <label for="date">Date:</label>
            <input type="text" id="date" placeholder="20/01/23"><br><br>
            <label for="order">Order number:</label>
            <input type="text" id="order" placeholder="12984"><br><br>
            <label for="name">Item name:</label>
            <input type="text" id="name" placeholder="Knights deck"><br><br>
            <label for="cost">Order cost</label>
            <input type="text" id="cost" placeholder="1662.87"><br><br>
            <label for="address">Delivery Address</label>
            <input type="text" id="address" placeholder="50, Blackberry street, Wooton"><br><br>
            


        </div>
        

    </form>

    </div>


</body>    
</html>