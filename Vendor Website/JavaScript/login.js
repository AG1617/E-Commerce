// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

//get input fields elements from page
let username = document.getElementById("auth_login_username");
let password = document.getElementById("auth_login_password");

//get login button element from page
let button = document.getElementById("login_submit");


// fucntion to if username is present
// highlights fields if empty
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

// fucntion to if password is present
// highlights fields if empty
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

// function to check login information by sending data to server
// and getting response
function validate_data(){

    //hidden div element which only appears when error messgae is to be displayed
    let error_message = document.getElementById("error_message");

    // if passes preliminary checks are passed then send data to server for athentication
    if (check_username() == true){

        if (check_password() == true){

            // new request to server to send login info to server for authentication
            let request = new XMLHttpRequest();

            // event handler based upon server response
            request.onload = () => {
                //Check HTTP status code
                if(request.status === 200){
                    //Get data from server
                    let responseData = request.responseText;

                    if (responseData == ""){
                        //Add data to page
                        //error message for unsuccessfull authentication
                        error_message.placeholder = "Username and Password do not match !";
                        error_message.style["visibility"] = "visible";
                        username.style["border-color"] = "red";
                        password.style["border-color"] = "red";

                    } else {
                        // redirect to home page
                        window.location.href="../Client_Side/Market.php";
                    }                
                }
                else
                // alert if connection to server failed
                    alert("Error communicating with server: " + request.status);
            };
            button.disabled = true;

            //Set up request with HTTP method and URL 
            request.open("POST", "../Server_Side/server_login.php");
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //Send request
            request.send("username=" + username.value + "&password=" + password.value);
        }

    }
}