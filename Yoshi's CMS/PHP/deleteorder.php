<?php
include('common.php');
output_navigation();    
?>
<!-- form to input id of order to be removed from line 6-17 -->
<div class="form">
        <h2>Delete order</h2>


    <form action="delorder.php" method="post">

        <label for="orderID">Order ID:</label><br>
        <input type="text" id="orderid" name="order_id"><br><br>
        <input type="submit" value="Delete">

    </form>

    </div>


</body>    
</html>