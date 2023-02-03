<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>
<!-- links to the different icons and fonts used -->

<?php
  session_start();

  session_unset();

  session_destroy();
?>
<head>
  <!-- php function to output title, meta tags and stylesheet -->
  <?php output_title_and_stylesheet_and_meta("Login Page", "../CSS/Login%20Page.css");?>
  <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("login");?>
<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("Login");?>
                  <!-- Container box -->
                <div id="auth_login" class="auth-box">
                  <!-- form for data input -->
                    <form class="auth-form">
                      <!-- Styling element -->
                      <div class="column-box">
                      </div>
            
                      <div class="column-box">
                        <!-- Data entry fields -->
                        <input onkeyup="check_username()" type="text" id="auth_login_username" name="_username" value="" placeholder="Username" required="required" autocorrect="off" spellcheck="false" autocomplete="off" class="text focus-field">
                      </div>
            
                      <div class="column-box">
                        <input onkeyup="check_password()" type="password" id="auth_login_password" name="_password" placeholder="Password" autocomplete="off" required="required" class="text">
                      </div>
            
                      <div class="column-box">
                        <!-- form submit button -->
                        <input onclick="validate_data()" type="submit" id="login_submit" class="btn-gold" name="_submit" value="Sign in">
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
<script src="http://localhost/JavaScript/login.js"></script>
<?php output_footer() ;?>