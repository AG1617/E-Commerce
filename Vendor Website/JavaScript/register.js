// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

let firstname = registration_form_firstname;
let lastname = registration_form_lastname;
let username = registration_form_username;
let address = registration_form_Address;
let password = registration_form_plainPassword;

let button = registration_form_submit;


function check_names(){

    let flag = true;

    if (firstname.value.length == 0){

        firstname.placeholder = "First Name Required";
        firstname.style["border-color"] = "Red";
        flag = false;

    }
    if (lastname.value.length == 0)
    {
        lastname.placeholder = "Last Name Required";
        lastname.style["border-color"] = "Red";
        flag = false;

    }

    return flag;
}

function enable_username(){
    button.disabled = false;
}

function check_address(){

    let flag = true;

    if(address.value.length == 0){

        address.placeholder = 'Address is required !';
        address.style["border-color"] = "red";

        flag = false;

    }

    return flag;
}

function check_password(){

    let flag = true;

    button.disabled = false;

    let regular_expression = new RegExp ("^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9@$!%*?&]{5,})$");
    let error_message = document.getElementById("error_message");

    if(password.value.length == 0){

        password.placeholder = 'Password is required !';
        password.style["border-color"] = "red";

        flag = false;

    } else if (!regular_expression.test(password.value)){

         /* Requirements are:

        1. At least 5 characters long
        2. One lowercase, one uppercase, one number
        3. No whitespaces.

    */
        error_message.style["visibility"] = "visible";
        error_message.placeholder = "Password needs at least 5 chars, 1 uppercase, lowercase,no whitespaces";
        password.style["border-color"] = "red";

        flag = false;

    }

    return flag;
}

function readData(){

    let error_message = document.getElementById("error_message");
    if (check_names() == true){

        firstname.style["border-color"] = "green";
        lastname.style["border-color"] = "green";
        error_message.style["visibility"] = "hidden";

        let regular_expression = new RegExp ("^(?=[a-zA-Z0-9._]{5,20}$)(?!.*[_.]{2})[^_.].*[^_.]$");

        if(username.value.length == 0){

            username.placeholder = 'Username is required !';
            username.style["border-color"] = "red";

            flag = false;

        } else if (!regular_expression.test(username.value)){

            /* Requirements are:

                1. should be 5-20 characters long
                2. no _ or . at the end
                3. no _ or . at the beginning
                4. no __ or _. or ._ or .. inside

            */
            error_message.style["visibility"] = "visible";
            error_message.placeholder = "Username should be 5-20 characters long, no _ or . allowed";
            username.style["border-color"] = "red";

            flag = false;

        }

        let request1 = new XMLHttpRequest();


        request1.onload = () => {
            //Check HTTP status code
            if(request1.status === 200){
                //Get data from server
                let responseData = request1.responseText;
                if (responseData == "true"){
                    error_message.style["visibility"] = "visible";
                    error_message.placeholder = "Username not available !";
                    username.style["border-color"] = "red";
                } else {
                    username.style["border-color"] = "green";
                    error_message.style["visibility"] = "hidden";
                    if (check_address() == true){

                        address.style["border-color"] = "green";
                        error_message.style["visibility"] = "hidden";
        
                        if(check_password() == true){
        
                            password.style["border-color"] = "green";
                            error_message.style["visibility"] = "hidden";
        
                            let request = new XMLHttpRequest();
                                
                            //Create event handler that specifies what should happen when server responds
                            request.onload = () => {
                                //Check HTTP status code
                                if(request.status === 200){
                                    // redirect to home page
                                    window.location.href="../PHP/Market.php";
                                }
                                else{
                                    alert("Error communicating with server: " + request.status);
                                }
                            };
                            
                            //Set up request with HTTP method and URL 
                            request.open("POST", "server_register.php");
                            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
                            //Send request
                            let new_customer_obj = 
                            {
                                firstname: firstname.value,
                                lastname: lastname.value,
                                username: username.value,
                                address: address.value,
                                password: password.value
                            };
        
                            let new_customer_str = JSON.stringify(new_customer_obj);
                            request.send("func=" + "create" + "&new_customer_str=" + new_customer_str );
                            
                        } else {
                            button.disabled = true;
                        }
                    }
                }
            }
        }
        button.disabled = true;
        //Set up request with HTTP method and URL 
        request1.open("POST", "server_register.php");
        request1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //Send request

        request1.send("func=" + "username" + "&username=" + username.value);
    }
}

            