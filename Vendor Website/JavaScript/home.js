// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

let login_btn = document.getElementById("login_button");
let register_btn = document.getElementById("register_button");
let display_area = document.getElementById("display_username");

window.onload = check_login();

function check_login(){

    let request = new XMLHttpRequest();

    request.onload = function() {

        if(request.status === 200){
            let responseData = request.responseText;

            let current_user = JSON.parse(responseData);

            if(current_user.length > 0){
                change_and_set_buttons();
                display_area.innerHTML = "Hi " + current_user[0] + " !";

            }
        }

    }

    request.open("GET", "server_home.php?func=login");
    request.send();
}

function change_and_set_buttons(){

    login_btn.innerHTML = "Logout";
    register_btn.innerHTML = "Account";

    let old_register_form = document.getElementById("register_form");
    let old_login_form = document.getElementById("login_form");

    old_register_form.action = "Account.php";
    old_login_form.action = "javascript:Logout()";

}

// fucntion log out user from its account
function Logout(){

    // re-sets login button to its initial values and clears welcome message
    let old_register_form = document.getElementById("register_form");
    let old_login_form = document.getElementById("login_form");
    let display_area = document.getElementById("display_username");

    login_btn.innerHTML = "Login";
    old_login_form.action = "Login.php";

    register_btn.innerHTML = "Sign Up";
    old_register_form.action = "Register.php";
    display_area.innerHTML = "";
    register_button.disabled = false;

    // redirect to home page
    window.location.href="../PHP/Login.php";
    

}

function search(){

    let search_bar = document.getElementById("search-bar");

    let search_value = search_bar.value;

    let request1 = new XMLHttpRequest();

    request1.onload = function() {

        if(request1.status === 200){
            let responseData = request1.responseText;

            output_search(responseData);

            if(current_user.length > 0){
                change_and_set_buttons();
                display_area.innerHTML = "Hi " + current_user[0] + " !";

            }
        }

    }

    request1.open("GET", "server_market.php?func=search&search_value=" + search_value);
    request1.send();


}

function output_search(jsonResults){

    if (jsonResults == "]"){

        let current_prod_collection = document.getElementsByTagName("li");
    
        while (current_prod_collection.length > 0){

            var prod = current_prod_collection[0];
            prod.parentNode.removeChild(prod);

        }

        let htmlStr = '<h1 id="no_result"> No Result Found !</h1>';

        document.getElementById("product_list").innerHTML = htmlStr;


    }

    let result_array = JSON.parse(jsonResults);

    // create the html to display
    let htmlStr = '';

    for (i = 0; i < result_array.length; i++){

        htmlStr += '<li>';
        htmlStr += '<img src="' + result_array[i].image_path + '"alt="' + result_array[i].deck_name + '">';
        htmlStr += '<h2>' + result_array[i].deck_name + '</h2>';
        htmlStr += '<h3>' + result_array[i].edition + '</h3>';
        htmlStr += '<p>' + result_array[i].price + '</p>';
        htmlStr += '<p><button class="addcart">Add to Cart</button></p>';
        htmlStr += '</li>';

    }

    let current_prod_collection = document.getElementsByTagName("li");
    
    while (current_prod_collection.length > 0){

        var prod = current_prod_collection[0];
        prod.parentNode.removeChild(prod);

    }

    document.getElementById("product_list").innerHTML = htmlStr;

}