// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

let username_field = document.getElementById("auth_edit_username");
let address_field = document.getElementById("auth_edit_address");
let password_field = document.getElementById("auth_edit_password");
let edit_btn = document.getElementById("login_submit");

let current_user_obj;

window.onload = check_login();

function check_login(){

    username_field.disabled = true;
    address_field.disabled = true;
    password_field.disabled = true;

    let request = new XMLHttpRequest();

    request.onload = function() {

        if(request.status === 200){
            let responseData = request.responseText;

            let user_details_arr = JSON.parse(responseData);

            if(user_details_arr.length > 0){
                
               current_user_obj = user_details_arr[0];

               let username = current_user_obj.username;
               let address = current_user_obj.address;
               let password = current_user_obj.password;

               username_field.placeholder = username;
               address_field.placeholder = address;
               password_field.placeholder = password;

            }
        }

    }

    request.open("GET", "server_account.php?func=account");
    request.send();
}

function edit(){

    username_field.disabled = false;
    address_field.disabled = false;
    password_field.disabled = false;

    username_field.value = current_user_obj.username;
    address_field.value = current_user_obj.address;
    password_field.value = current_user_obj.password;

    edit_btn.value = "Save details";
    edit_btn.onclick = function() {save_details()};

}

function save_details(){

    let id = current_user_obj._id.$oid;
    let username = username_field.value;
    let address = address_field.value;
    let password = password_field.value;

    let con_username;

    let error_message = document.getElementById("error_message");

    let regular_expression = new RegExp ("^(?=[a-zA-Z0-9._]{5,20}$)(?!.*[_.]{2})[^_.].*[^_.]$");

    if (!regular_expression.test(username)){

        /* Requirements are:

            1. should be 5-20 characters long
            2. no _ or . at the end
            3. no _ or . at the beginning
            4. no __ or _. or ._ or .. inside

        */
        error_message.style["visibility"] = "visible";
        error_message.placeholder = "Username should be 5-20 characters long, no _ or . allowed";
        username_field.style["border-color"] = "red";

    }

    let request2 = new XMLHttpRequest();


    request2.onload = () => {
        //Check HTTP status code
        if(request2.status === 200){
            //Get data from server
            let responseData = request2.responseText;
            if (responseData == "true"){
                error_message.style["visibility"] = "visible";
                error_message.placeholder = "Username not available !";
                username_field.style["border-color"] = "red";
            } else {
                username_field.style["border-color"] = "#7c7c7c";
                error_message.style["visibility"] = "hidden";
                con_username = username;
            }
        }
        if (!con_username == ""){
            let request1 = new XMLHttpRequest();
    
            request1.onload = function() {
    
                if(request1.status === 200){
                    let responseData = request1.responseText;
                    if (responseData == "Customer document successfully replaced."){
                        check_login();
                        edit_btn.value = "Edit details";
                        edit_btn.onclick = function() {edit()};
                    } else {
                        check_login();
                        edit_btn.value = "Edit details";
                        edit_btn.onclick = function() {edit()};
                    }
    
                } else {
                alert("Error communicating with server: " + request1.status);
                }
    
            }
    
            //Set up request with HTTP method and URL 
            request1.open("POST", "server_account.php");
            request1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
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
    request2.open("POST", "server_account.php");
    request2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //Send request

    request2.send("func=" + "username" + "&username=" + username);

    
}

