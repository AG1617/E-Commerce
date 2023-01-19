<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>

<!-- links to the different icons and fonts used -->
<head>
    <!-- php function to output title, meta tags and stylesheet -->
    <?php output_title_and_stylesheet_and_meta("Past Orders Page", "../CSS/Register.css");?>
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("Register");?>
<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("register");?>
                    <!-- Container box -->
                <div id="auth_register" class="auth-box">
                    <!-- form for data input -->
                    <form name="register-form" action="#Register">
                        <div id="registration_form" ng-non-bindable="true">
                            <!-- Styling container -->
                            <div class="col">
                                <!-- data entry fields -->
                                <input type="text" id="registration_form_firstname" name="registration_form[firstname]" required="required" class="text form-control" placeholder="First Name">        
                            </div>
                            <div class="col">
                                <input type="text" id="registration_form_lastname" name="registration_form[lastname]" required="required" class="text form-control" placeholder="Last Name">        
                            </div>
                            <div class="col">
                                <input type="text" id="registration_form_username" name="registration_form[username]" required="required" class="text form-control" placeholder="Username">        
                            </div>
                            <div class="col">
                                <input type="text" id="registration_form_Address" name="registration_form[address]" required="required" class="text form-control" placeholder="Address">        
                            </div>
                            <div class="col-1">
                                <input type="password" id="registration_form_plainPassword" name="registration_form[plainPassword]" required="required" class="text form-control" placeholder="Password">        
                            </div>
                            <!-- form submit button -->
                            <button type="submit" id="registration_form_submit" name="registration_form[submit]" class="btn-gold">Create Your Account</button>

                    </form>
                    </div>

            </div>

        </div>

    </div>
<!-- php function to output body and html closing tags -->
<?php output_footer() ;?>