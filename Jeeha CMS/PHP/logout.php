<!--PHP-->
<?php

    //Start session management
    session_start();

    //Remove all session variables
    session_unset();
    
    //Destroy the session
    session_destroy();

     

    //Display successful message
    echo '<script>alert("Log out successful");</script>'; 

    //Redirect user to the login page
    echo '<script>window.location.href="login.php";</script>';  

?>