<?php
include('common.php');
output_navigation();    
?>

<div class="form1">
        <p>LogIn</p>
     <!-- Form which includes Username and password input field-->
    <form class="box" action="check_login.php" method="post">
     <label for="username">Username:</label>
     <input onkeyup="check_username()" style="width:140px;font-size:20px;" type="text" id="username" name="username" class="username">
     <br><br>
     <label for="password">Password: </label>
     <input onkeyup="check_password()" style="width:140px;font-size:20px;" type="password" id="password" name="password" class="password">
     <br><br>
    <!-- Submit Button-->
     <input style="margin-left:80px;margin-top:10px;font-size:20px;" type="submit" value="Submit" id="login_submit" onclick="validate_data()" class="button" style="font-size:20px">
    </form> 

    

    </div>


    <script src="../JS/login.js"></script>


</body>    
</html>