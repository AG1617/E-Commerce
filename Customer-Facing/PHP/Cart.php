<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>

<!-- links to the different icons and fonts used -->
<head>
    <!-- php function to output title, meta tags and stylesheet -->
    <?php output_title_and_stylesheet_and_meta("Cart Page", "../CSS/Cart.css");?>
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("CART");?>

<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("cart");?>

            <!-- Class for each item selected to put in cart -->
            <div class="items">
                <div class="image">
                    <img src="../../Images/Knights.png" style="height:120px" />
                </div>
                <div class="details">
                    <h1 class="deck-name" id="deck-name">Knights Playing Card</h1>
                    <h3 class="press-type"id="press-type">USPCC Crushed</h3>
                </div>
                <div class="count-selector">
                    <div class="btn">+</div>
                    <div class="count">2</div>
                    <div class="btn">-</div>
                </div>
                <div class="price">
                    <div class="amount">Rs 340.99</div>
                    <div class="remove"><u>Remove</u></div>
                </div>  
            </div>

            <div class="items">
                <div class="image">
                    <img src="../../Images/aurelian.png" style="height:120px" />
                </div>
                <div class="details">
                    <h1 class="deck-name" id="deck-name">White Aurelians Playing Card</h1>
                    <h3 class="press-type"id="press-type">Luxury-pressed E7</h3>
                </div>
                <div class="count-selector">
                    <div class="btn">+</div>
                    <div class="count">2</div>
                    <div class="btn">-</div>
                </div>
                <div class="price">
                    <div class="amount">Rs 440.99</div>
                    <div class="remove"><u>Remove</u></div>
                </div>  
            </div>

            <div class="items">
                <div class="image">
                    <img src="../../Images/killer.png" style="height:120px" />
                </div>
                <div class="details">
                    <h1 class="deck-name" id="deck-name">Super Bees Playing Card</h1>
                    <h3 class="press-type"id="press-type">USPCC Crushed</h3>
                </div>
                <div class="count-selector">
                    <div class="btn">+</div>
                    <div class="count">2</div>
                    <div class="btn">-</div>
                </div>
                <div class="price">
                    <div class="amount">Rs 880.99</div>
                    <div class="remove"><u>Remove</u></div>
                </div>  
            </div>

            <!-- Div for displaying of Subtotal and no of items -->
            <hr> 
            <div class="checkout">
            <div class="total">
                <div>
                    <div class="Subtotal">Sub-Total</div>
                    <div class="items">3 items</div>
                </div>
                <div class="total-amount">Rs 1662.87</div>
            </div>
            <!-- Buttons linking to checkout page -->
            <form action="Checkout.php"><button class="button">Proceed to Checkout</button></form>
            </div>
            

        </div>
    </div>
<!-- php function to output body and html closing tags -->
<?php output_footer() ;?>