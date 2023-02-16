"use strict";

// Global variable i used for loops
let i = 0;

let username = document.getElementById("username");
let password = document.getElementById("password");

let button = document.getElementById("login_submit");

//Function to check username field
function check_username(){

    let flag = true;
    button.disabled = false;

    if (username.value.length == 0){

        username.placeholder = "Username Required";
        username.style["border-color"] = "Red";
        flag = false;

    }
    return flag;
}

//function to check password field
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

//function to check username and password and display relevant error messages
function validate_data(){


    if (check_username() === true){

        if (check_password() === true){

            let request = new XMLHttpRequest();

            request.onload = () => {
                //Check HTTP status code
                if(request.status === 200){
                    //Get data from server
                    let responseData = request.responseText;

                    if (responseData === ""){
                        //show error message
                        alert("Username and Password do not match !");
                    } else {
                        // redirect to home page
                        window.location.href="../PHP/index.php";
                    }                
                }
                else
                    alert("Error communicating with server: " + request.status);
            };
            button.disabled = true;

            //Set up request with HTTP method and URL 
            request.open("POST", "check_login.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //Send request
            request.send("username=" + username.value + "&password=" + password.value);
        }

    }
}