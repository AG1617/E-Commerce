<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>
<?php include '../Server_Side/server_market.php';?>

<!-- links to the different icons and fonts used -->
<head>
    <!-- php function to output title, meta tags and stylesheet -->
    <?php output_title_and_stylesheet_and_meta("Market Page", "../../CSS/Market%20Page.css");?>
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- div to contain website logo, name, account buttons and cart buttons plus logo -->
    <div class="header">

        <img src="..\..\Images\logo_final.png" alt="logo">

        <h1>Illusionist Cards</h1>

        <!-- buttons linking to the login page , sign-up , and  cart page respectively -->

        <form action="Login.php" class="form" id="login_form"><button class="custom-btn login" id="login_button"><span>Login</span></button></form>
        
        <form action="Register.php" class="form" id="register_form"><button class="custom-btn sign-up" id="register_button"><span>Sign Up</span></button></form>

        <p class="Username" id="display_username"></p>

        <a href="Cart.php" class="form" id="cart_link">Cart</a>

    </div>


    <!-- div to display large cental image maching website style and intro to products -->
    <div class="central-image">

    <!-- php function to display recurrent navigation bar -->
    <?php output_navigation_bar("MARKET");?>

        <div class="container">
            <h1>Playing Cards</h1>
            <p>The world's finest playing cards. Featuring custom artwork, gold foil card boxes, 
                premium embossing, and the highest quality stock and finishes. The result is an exquisite 
                blend of beauty and elegance. Made For You.
            </p>
        </div>
        
    </div>

    <!-- div containing a .png image which will seperate the two halves of the page -->
    <div class="separator-border"></div>
    
    <!-- php function to output div container for displaying of products and for sort and search buttons -->
    <?php output_main_body_and_container("market");?>
            <!-- unordered list of products -->

            <?php display_products() ?>
            
        </ul>

        
    </div>
<!-- php function to output body and html closing tags -->
<script src="http://localhost/Customer-Facing/JavaScript/home.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php output_footer() ;?>