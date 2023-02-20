// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

// getting all text-entry fields and submit button
let username_field = document.getElementById("auth_edit_username");
let address_field = document.getElementById("auth_edit_address");
let password_field = document.getElementById("auth_edit_password");
let edit_btn = document.getElementById("login_submit");

//global variable for the current user details
let current_user_obj;

// call fucntion upon page loading
window.onload = check_login();

// fucntion to check if a user is currently logged in
// and displays user info as placeholder values if yes
function check_login(){

    username_field.disabled = true;
    address_field.disabled = true;
    password_field.disabled = true;

    // new request to server to check if logged in
    let request = new XMLHttpRequest();

    // event handler based upon server response
    request.onload = function() {

        //  only if successfull connection to server
        if(request.status === 200){
            let responseData = request.responseText;

            // parsing user JSON data recieved from server
            let user_details_arr = JSON.parse(responseData);

            // check if array of users is not empty
            if(user_details_arr.length > 0){
                
                // get current user object
               current_user_obj = user_details_arr[0];

               let username = current_user_obj.username;
               let address = current_user_obj.address;
               let password = current_user_obj.password;

               // displaying user data in text fields as placeholder
               username_field.placeholder = username;
               address_field.placeholder = address;
               password_field.placeholder = password;

            }
        }

    }

    //Set up request and send it
    request.open("GET", "../Server_Side/server_account.php?func=account");
    request.send();
}


// fucntion to allow user to edit his account details before saving
function edit(){

    username_field.disabled = false;
    address_field.disabled = false;
    password_field.disabled = false;

    // get new account details
    username_field.value = current_user_obj.username;
    address_field.value = current_user_obj.address;
    password_field.value = current_user_obj.password;

    // set fucntion to be executed when user clicks 'save'
    edit_btn.value = "Save details";
    edit_btn.onclick = function() {save_details()};

}

// fucntion which takes new modified account details and sends
// it to server to update data
function save_details(){

    let id = current_user_obj._id.$oid;
    let username = username_field.value;
    let address = address_field.value;
    let password = password_field.value;

    let con_username;

    // hidden field which is displayed only when
    // error message needs to be ouputted to user
    let error_message = document.getElementById("error_message");

    // regex to validate username
    let regular_expression = new RegExp ("^(?=[a-zA-Z0-9._]{5,20}$)(?!.*[_.]{2})[^_.].*[^_.]$");


    // validate new username
    if (!regular_expression.test(username)){

        /* Requirements are:

            1. should be 5-20 characters long
            2. no _ or . at the end
            3. no _ or . at the beginning
            4. no __ or _. or ._ or .. inside

        */

        // display error message
        error_message.style["visibility"] = "visible";
        error_message.placeholder = "Username should be 5-20 characters long, no _ or . allowed";
        username_field.style["border-color"] = "red";

    }


    // new request to server to check if username is unique
    let request2 = new XMLHttpRequest();


    // event handler based upon server response
    request2.onload = () => {

        //Check HTTP status code
        if(request2.status === 200){

            //Get data from server
            let responseData = request2.responseText;

            //username is not unique
            if (responseData == "true"){
                error_message.style["visibility"] = "visible";
                error_message.placeholder = "Username not available !";
                username_field.style["border-color"] = "red";

                // valid username
            } else {
                username_field.style["border-color"] = "#7c7c7c";
                error_message.style["visibility"] = "hidden";

                //set final username to variable
                con_username = username;
            }
        }

        // check if final username has been set
        if (!con_username == ""){

            // new request to server to updata customer account data
            let request1 = new XMLHttpRequest();
    
            // event handler based upon server response
            request1.onload = function() {
    
                //Check HTTP status code
                if(request1.status === 200){
                    let responseData = request1.responseText;

                    // correctly updated
                    if (responseData == "Customer document successfully replaced."){
                        check_login();
                        edit_btn.value = "Edit details";
                        edit_btn.onclick = function() {edit()};

                        // error message displayed
                    } else {

                        alert("Error updating account details ");
                    }
    
                    // error message if connection to server failed
                } else {
                alert("Error communicating with server: " + request1.status);
                }
    
            }
    
            //Set up request with HTTP method and URL 
            request1.open("POST", "../Server_Side/server_account.php");
            request1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    

            // create new user object with updated data
            let customer_obj = 
            {
                id: id,
                username: con_username,
                address: address,
                password: password
            };
    
            let customer_str = JSON.stringify(customer_obj);
    
            //Send request
    
            request1.send("func=" + "save" + "&customer_str=" + customer_str);
    
        }
    }

    //Set up request with HTTP method and URL 
    request2.open("POST", "../Server_Side/server_account.php");
    request2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    //Send request
    request2.send("func=" + "username" + "&username=" + username);

    
}

