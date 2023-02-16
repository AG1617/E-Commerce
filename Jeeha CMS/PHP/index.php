<?php
include('common.php');
output_navigation();     
?>

<?php

session_start();


if(isset($_GET['logout'])){
   session_destroy();
    header('Location: login.php');
    echo '<script>alert("Log out successful");</script>';
}

?>


<!-- welcome message and login link to be displayed on home page-->
<div class="welcome">
        <h1>Welcome</h1><br>

        <?php 
            
            if(isset($_SESSION["loggedInStaffName"]) && !empty($_SESSION["loggedInStaffName"])){
                
                echo '<p>Hello '.$_SESSION["loggedInStaffName"].', Use the navigation to manage content</p> <a href="logout.php?logout=1"><button style="width:70px;font-size:25px;border-radius:5px;">Logout</button></a>';
                
            }else 

               echo '<h2>Please log in to get access to other pages. Click on link below to log in</h2><br>

        
               <p><a href="login.php" class="link">Log In!</a></p>
       
           </div>
           
       </body>
       </html>'
            
            
            ?>

        