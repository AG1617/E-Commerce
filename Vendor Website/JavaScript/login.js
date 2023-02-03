// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

let username = document.getElementById("auth_login_username");
let password = document.getElementById("auth_login_password");

let button = document.getElementById("login_submit");

function check_username(){

    let flag = true;
    button.disabled = false;

    if (username.value.length == 0){

        username.placeholder = "First Name Required";
        username.style["border-color"] = "Red";
        flag = false;

    }
    return flag;
}

function check_password(){

    let flag = true;
    button.disabled = false;

    if (password.value.length == 0){

        password.placeholder = "Password Required";
        password.style["border-color"] = "Red";
        flag = false;

    }
    return flag;
}

function validate_data(){

    let error_message = document.getElementById("error_message");

    if (check_username() == true){

        if (check_password() == true){

            let request = new XMLHttpRequest();

            request.onload = () => {
                //Check HTTP status code
                if(request.status === 200){
                    //Get data from server
                    let responseData = request.responseText;

                    if (responseData == ""){
                        //Add data to page
                        error_message.placeholder = "Username and Password do not match !";
                        error_message.style["visibility"] = "visible";
                        username.style["border-color"] = "red";
                        password.style["border-color"] = "red";

                    } else {
                        // redirect to home page
                        window.location.href="../PHP/Market.php";
                    }                
                }
                else
                    alert("Error communicating with server: " + request.status);
            };
            button.disabled = true;

            //Set up request with HTTP method and URL 
            request.open("POST", "server_login.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //Send request
            request.send("username=" + username.value + "&password=" + password.value);
        }

    }
}