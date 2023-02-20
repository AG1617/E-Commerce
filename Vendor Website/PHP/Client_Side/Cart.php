<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>

<!-- links to the different icons and fonts used -->
<head>
    <!-- php function to output title, meta tags and stylesheet -->
    <?php output_title_and_stylesheet_and_meta("Cart Page", "../../CSS/Cart.css");?>
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("CART");?>

<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("cart");?>

            <!-- Class for each item selected to put in cart -->


            <!-- Div for displaying of Subtotal and no of items -->
            <hr> 
            <div class="checkout">
            <div class="total">
                <div>
                    <div class="Subtotal">Sub-Total</div>
                    <div id="item_count" class="item-count">3 items</div>
                </div>
                <div id="total_amount" class="total-amount">Rs 1662.87</div>
            </div>
            <!-- Buttons linking to checkout page -->
            <button onclick="checkout()" class="button">Proceed to Checkout</button>
            </div>
            

        </div>
    </div>
<!-- php function to output body and html closing tags -->
<script src="http://localhost/Customer-Facing/JavaScript/cart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php output_footer() ;?>