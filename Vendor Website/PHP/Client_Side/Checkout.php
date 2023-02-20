<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>

<!-- links to the different icons and fonts used -->
<head>
  <!-- php function to output title, meta tags and stylesheet -->
  <?php output_title_and_stylesheet_and_meta("Checkout Page", "../../CSS/Checkout.css");?>
  <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("checkout");?>

<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("checkout");?>
                  <!-- container div for contact info and address -->
                  <div class="box-row">
                    <div class="checkout-details">
                      <h3>Contact Information and Shipping</h3>
                      <label for="full-name">Full Name</label>
                      <input type="text" id="full-name" name="name" placeholder="Full name" required>
                      <label for="email">Email Address</label>
                      <input type="text" id="email" name="email" placeholder="name@example.com" required>
                      <label for="address">Address</label>
                      <input type="text" id="address" name="address" placeholder="example street" required>
                      <label for="Town">Town</label>
                      <input type="text" id="Town" name="Town" placeholder="example town" required>

                      <!-- pcontainer div for phone number and zip code -->
                      <div class="box-row">
                            <div class="checkout-details">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" placeholder="5XXXXXXX" required>
                            </div>
                            <div class="checkout-details">
                                <label for="zip-code">Zip</label>
                                <input type="text" id="zip-code" name="zip" placeholder="73643" required>
                            </div>
                      </div>
                    </div>
        
                  </div>
                  <!-- submit button for confirming order -->
                  <button onclick="get_id()" class="buy" id="buy">Buy Now</button>
                
              </div>
            </div>

            <!-- div container for summary of cart contents -->
            <div class="summary-and-recommendation">
              <div id="checkout-box" class="checkout-box">
              
              </div>

              <!-- div container to display recommended items based on tracking data -->
              <div class="tracking-box" id="tracking-box">
                    <h4 class="recommended">Recommended For You Based On Your Recent Searches</h4>
                    <p>
                        <img src="../../Images/Knights.png" alt="knights">
                        <span class="Item-name"> Knights Playing Card <br> <span class="price-track">Rs 340</span> </span>
                        <button class="add"> Add </button>
                    </p>
                    <p>
                        <img src="../../Images/aurelian.png" alt="aurelian">
                        <span class="Item-name"> Aurelian Playing Card <br> <span class="price-track">Rs 340</span> </span>
                        <button class="add"> Add </button>
                    </p>

                    <h4 class="recommended">Recommended For You Based On Your Price Range</h4>

                    <hr>

              </div>
            </div>
        </div>

    </div>
<!-- php function to output body and html closing tags -->
<script src="http://localhost/Customer-Facing/JavaScript/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php output_footer() ;?>