<?php

    /* Funtion to output page title, meta tags and path to correct external style sheet */
    function output_title_and_stylesheet_and_meta($title, $path){
        echo '<title> Illusionist Cards - ' . $title . '</title>';
        echo '<link rel="stylesheet" href=' .$path . '>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    }

    /* Funtion to output the recurrent navigation bar across pages and display the active hyperlink */
    function output_navigation_bar($name_of_active_page){

        /* if current page is not home page */
        if($name_of_active_page != "MARKET"){ 
            echo '<body>';
        }
        echo '
        <div class="navigation-bar">';
        if($name_of_active_page != "MARKET"){
            echo '<img src="../Images/logo_final.png" alt="logo">
    
            <h1>Illusionist Cards</h1>';
        }
    
        echo '<ul class="nav-main">';

            /* Array containing paths to different pages. Can be accessed from navigation bar */
            $hyperlinks = array("Order.php", "Market.php", "Cart.php");

            /* Array containing the names of the pages that can be accessed from navigation bar */
            $hyperlink_name = array("PAST ORDERS", "MARKET", "CART");

            /* Iterating through array to create and output list of links which are to be used for navigation */
            for($x = 0; $x < count($hyperlink_name); $x++){             
                echo '<li ';
                /* Selecting which page is currently active */
                if ($hyperlink_name[$x] == $name_of_active_page){
                    /* setting a different class for active page */
                    echo 'class="nav-main-link-selected"';      
                } else{
                    echo 'class="nav-main-link"';
                }
                echo '<br>';
                /* setting the respective addresses to the hyperlinks */
                echo '  <a href="' . $hyperlinks[$x] . '">' . $hyperlink_name[$x];      
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>

            </div>';
    }

    /* Funtion to output the recurrent main body class */
    function output_main_body_and_container($page_name){

        /* variable determines currently active page and selection is performed to determine which html code to ouput */
        switch ($page_name){                            

            case "cart":
                echo '<div class="main-body">
                <div class="img-container"></div>
                <h1>Review Your Order</h1>
        
                <div class="cart-frame">
                    <div class="frame-name">
                        <h3 class="title">Shopping Cart</h3>
                        <h5 class="action">Remove all</h5>
                    </div>';
                break;

            case "checkout":
                echo '<div class="main-body">

                <h1 class="page-title">Checkout</h1>
        
                <div class="box-row">
                    <div class="billing-box">
                      <div class="checkout-box">
                        <form action="#CONFIRMATION">';
                break;

            case "Login":
                echo '<div class="main-body">

                <h1>Illusionist Cards Account</h1>
        
                <div class="box">
                    <div class="inner-box">
                        <ul class="auth-nav">
        
                            <li class="login">
                                <a class="active" href="Login.php"><span>Sign In</span></a>
                            </li>
        
                            <li class="register">
                                <a href="Register.php"><span>Create Account</span></a>
                            </li>
        
                        </ul>';
                break;

            case "Account":
                echo '<div class="main-body">

                <h1>Edit Account Details</h1>
        
                <div class="box">
                    <div class="inner-box">';
                break;

            case "order":
                echo '<div class="main-body">

                <h1 class="page-title">Order History</h1>
        
                <div class="container">
                    <table class="Past-orders" id="order_table">
                        <tr class="headings">
                            <th>Date</th>
                            <th>Order No.</th>
                            <th>Item Name</th>
                            <th>Item Cost</th>
                            <th>Item Count</th>
                            <th>Order Cost</th>
                            <th>Delivery Address</th>
                        </tr>';
                break;
            case "register":
                echo '<div class="main-body">

                <h1>Illusionist Cards Account</h1>
        
                <div class="box">
                    <div class="inner-box">
                        <ul class="auth-nav">
        
                            <li class="login">
                                <a href="Login.php"><span>Sign In</span></a>
                            </li>
        
                            <li class="register">
                                <a class="active" href="Register.php"><span>Create Account</span></a>
                            </li>
        
                        </ul>';
                break;

            default:
            echo '<div class="main-body">
            <h1>Available Playing Cards</h1>
            <div class="filter">
                <label class="order-text" for="sort-by"> Order By: </label>
                <select class="filters" name="filters" id="filters">
                    <option value="default">Default</option>
                    <option value="descending">Price , High to Low</option>
                    <option value="ascending">Price , Low to High</option>
                </select>
                <div class="search-box">
                    <input type="text" id="search-bar" class="search-input" placeholder="Start Looking For Something!">
                    <button class="search-btn" onclick="search()">
                      <!-- Seach Icon -->
                      <span class="material-symbols-outlined">
                        search
                        </span>
                    </button>
                </div>
            </div>
    
    
            <ul class="product-list" id="product_list">';
        }

    }

    /* Funtion to output the body and html closing tags */
    function output_footer(){
        echo '</body>';
        echo '</html>';
    }

?>