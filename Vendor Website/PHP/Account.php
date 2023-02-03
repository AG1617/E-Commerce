<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>
<!-- links to the different icons and fonts used -->

<head>
  <!-- php function to output title, meta tags and stylesheet -->
  <?php output_title_and_stylesheet_and_meta("Account Page", "../CSS/Account.css");?>
  <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("account");?>
<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("Account");?>
                  <!-- Container box -->
                <div id="auth_login" class="auth-box">
                  <!-- form for data input -->
                    <form class="auth-form">
                      <!-- Styling element -->
                      
                      <div class="column-box">
                        <label class="labels" for="username">Username</label>
                        <!-- Data entry fields -->
                        <input disabled onkeyup="" type="text" id="auth_edit_username" name="_username" value="" placeholder="Username" required="required" autocorrect="off" spellcheck="false" autocomplete="off" class="text focus-field">
                      </div>

                      <div class="column-box">
                        <label class="labels" for="Address">Address</label>
                        <!-- Data entry fields -->
                        <input disabled onkeyup="" type="text" id="auth_edit_address" name="_address" value="" placeholder="Address" required="required" autocorrect="off" spellcheck="false" autocomplete="off" class="text focus-field">
                      </div>
            
                      <div class="column-box">
                        <label class="labels" for="Password">Password</label>
                        <input disabled onkeyup="" type="text" id="auth_edit_password" name="_password" placeholder="Password" autocomplete="off" required="required" class="text">
                      </div>
            
                      <div class="column-box">
                        <!-- form submit button -->
                        <input onclick="edit()" type="button" id="login_submit" class="btn-gold" name="_submit" value="Edit Details">
                      </div>
                      
                      <div class="column-box">
                        <input type="text" id="error_message">
                      </div>

                    </form>
                  </div>

            </div>

        </div>

    </div>
<!-- php function to output body and html closing tags -->
<script src="http://localhost/JavaScript/account.js"></script>
<?php output_footer() ;?>