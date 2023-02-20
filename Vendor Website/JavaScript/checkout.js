// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

//get the final version of the cart array from the HTML session storage
let final_cart_str = sessionStorage.final_cart;

// variables which will store recommended products based on searches tracking
let search_recommended;

//g get the parsed version of data in session storage
let final_cart_arr = JSON.parse(final_cart_str);

class Tracker {
    //Holds the keywords
    keywords = {};

    //Keywords older than this window will be deleted
    timeWindow = 1800000;

    constructor(){
        this.load();
    }

    //Adds a keyword to the Tracker
    addKeyword(word){
        //Increase count of keyword
        if(this.keywords[word] === undefined)
            this.keywords[word] = {count: 1, date: new Date().getTime()};
        else{
            this.keywords[word].count++;
            this.keywords[word].date = new Date().getTime();
        }
        
        
        //Save state of Tracker
        this.save();
    }

    //Returns the most popular keyword
    getTopKeyword(){
        //Clean up old keywords
        this.deleteOldKeywords();
        
        //Return word with highest count
        let maxCount = 0;
        let maxKeyword = "";
        for(let word in this.keywords){
            if(this.keywords[word].count > maxCount){
                maxCount = this.keywords[word].count;
                maxKeyword = word;
            }
        }
        return maxKeyword;
    }

    /* Saves state of Tracker */
    save(){
        localStorage.TrackerKeywords = JSON.stringify(this.keywords);
    };

    /* Loads state of Tracker */
    load(){
        if(localStorage.TrackerKeywords === undefined)
            this.keywords = {};
        else
            this.keywords = JSON.parse(localStorage.TrackerKeywords);
        
        //Clean up keywords by deleting old ones
        this.deleteOldKeywords();
    };
    
    //Removes keywords that are older than the time window
    deleteOldKeywords(){
        let currentTimeMillis = new Date().getTime();
        for(let word in this.keywords){
            if(currentTimeMillis - this.keywords[word].date > this.timeWindow){
                delete this.keywords[word];
            }
        }
        this.save();
    }
}

// new instance of tracker 
let tracker = new Tracker();

// set event handler to Buy Now button
document.getElementById("buy").onclick = get_id;

// check if customer is logged in each time page loads
window.onload = check_login();

// fucntion to check if a user is currently logged in
// fills in customer data in checkout data fields if yes
function check_login(){

    // new request to server to check if logged in
    let request = new XMLHttpRequest();

    // event handler based upon server response
    request.onload = function() {

        let responseData = request.responseText;

        // if user is logged in
        if (responseData != ""){

            // parse current user object recieved from recieved
            let current_user = JSON.parse(responseData);

            if(current_user.length > 0){

                // call fucntion to fill in user details and 
                // display recommended products based on customer tracking
                fill_in(current_user[0], current_user[1], current_user[2]);
                recommender();

            }
        } else {

            // user not logged in, hence only display recommended products and mini cart summary
            recommender();
            display_cart_summary();

        }
        

    }

    //Set up request and send it
    request.open("GET", "../Server_Side/server_checkout.php?func=login");
    request.send();

}

// fucntion which fills in data entry fields on page
// if a user is logged in. Recieves customer fist and last name as well as address
function fill_in(f_name, l_name, address){

    let full_name = document.getElementById("full-name");
    let address_field = document.getElementById("address");

    full_name.value = f_name + ' ' + l_name;

    address_field.value = address;

    // displays a mini cart summary
    display_cart_summary();

    

}

//fucntion which displays a summary of the cart with only item name, price and number of
//items as well as total price.
function display_cart_summary(){

    // get final cart from session storage
    final_cart_arr = JSON.parse(sessionStorage.final_cart);

    const div_ele = document.getElementById("checkout-box");

    // remove all HTML elements which were previously being displayed
    // indide DIV
    while(div_ele.lastElementChild){
        div_ele.removeChild(div_ele.lastElementChild);
    }

    // initialising variable containing HTML code to be displayed
    let htmlStr = '';

    // initialising subtotal of all items to be bought
    let total = 0;

    // displays number of unique items to be bought
    htmlStr += '<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>' + final_cart_arr.length + '</b></span></h4>';

    // for each product in cart, display name and cost of all istances to be bought
    for ( i = 0; i < final_cart_arr.length; i++){

        htmlStr += '<p><a>' + final_cart_arr[i].DeckName + '</a> <span class="price">Rs ' + (final_cart_arr[i].cost * final_cart_arr[i].count) + '</span></p>';

        // keep track of sub total
        total = total + (final_cart_arr[i].cost * final_cart_arr[i].count)

    }

    htmlStr += '<hr>';

    // displays subtotal
    htmlStr += '<p>Total <span class="price" style="color:black"><b>Rs ' + total.toFixed(2) + '</b></span></p>';

    // insert HTML code in page
    div_ele.innerHTML = htmlStr;

}
function checkemail(email){

    // Regular expression for email validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Test the email against the regular expression
    return emailRegex.test(email);
}

function checkphone(phonenum){

    // Regular expression for phone number validation
    var phoneRegex = /^5\d{7}$/;

    // Test the phone number against the regular expression
    return phoneRegex.test(phonenum);
}

function checkzip(zipCode){

    // Regular expression for zip code validation
    var zipRegex = /^\d{5}$/;

    // Test the zip code against the regular expression
    return zipRegex.test(zipCode);
}
// function executed when user clicks the 'buy now' button
// gets the id of the currently logged in user and checks if 
// all input fields have been filled before calling the buy now 
// fucntion
function get_id(){
     
    // new request to server to get currently logged user
    let request1 = new XMLHttpRequest();

    // event handler based upon server response
    request1.onload = function() {

        // get current user object from server
        let responseData = request1.responseText;

        let current_user_id = JSON.parse(responseData);

        if(current_user_id.length > 0){

            let email = document.getElementById("email").value;
            let town = document.getElementById("Town").value;
            let phone = document.getElementById("phone").value;
            let zip = document.getElementById("zip-code").value;

            // check if all fields have been filled
            if (email != "" && town != "" && phone != "" && zip != "")
            {
                if (checkemail(email) == true){

                    if (checkphone(phone) == true){

                        if (checkzip(zip) == true){

                            buy_now(current_user_id[0], current_user_id[1]);

                        } else {
                            alert("Please valid zip code with 5 digits in length !");
                        }
                    } else {
                        alert("Please enter valid phone number starting with 5 and 8 digits in length !");
                    }
                    
                } else {
                    alert("Please enter valid email !");
                }

                // if not, display error message
            } else {

                alert("Please fill in all fields !");
            }
        }

    }

    //Set up request and send it
    request1.open("GET", "../Server_Side/server_checkout.php?func=current_id");
    request1.send();
}


// function which takes all necessary information and
// contructs a new order object and sends it to server to 
// record. Recieves the current user id as well as his address as parameters
function buy_now(customer_id, address){

    // get the sub total of the order
    let total = 0;

    for (let x = 0; x < final_cart_arr.length; x++){

        total = total + (final_cart_arr[x].cost * final_cart_arr[x].count)

    }

    // gets the current date if dd/mm/yyyy format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '/' + mm + '/' + yyyy;

    // initialises the array of products
    let product_arr = [];

    // constructs the product object with only the necessary 
    // fields and inserts it in the array
    for (let x = 0; x < final_cart_arr.length; x++){

        let new_prod_object =
        {
            name: final_cart_arr[x].DeckName,
            count: final_cart_arr[x].count,
            price: final_cart_arr[x].cost

        };

        product_arr.push(new_prod_object);
    }

    // creates new order object in format as used in database
    let new_order_obj = 
    {
        customer_id: customer_id.$oid,
        delivery_address: address,
        order_cost: total,
        date: today,
        products: product_arr

    };

    // puts new order in JSON format to send to server
    let new_order_str = JSON.stringify(new_order_obj);

    // new request to server to send new order info
    let request2 = new XMLHttpRequest();

    // event handler based upon server response
    request2.onload = () => {

        //Check HTTP status code
        if(request2.status === 200){

            //resets all input fields upon successfull server connection
            document.getElementById("email").value = "";
            document.getElementById("Town").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("zip-code").value = "";

            let new_cart = [];

            //resets all carts in session storage
            sessionStorage.cart = JSON.stringify(new_cart);
            sessionStorage.final_cart = JSON.stringify(new_cart);

            //display resetted mini cart summary
            display_cart_summary();

            //display order confirmed page
            window.location.href = "http://localhost/Customer-Facing/PHP/Client_Side/Confirmation.php";

        }
        // display error message
        else{
            alert("Error communicating with server: " + request2.status);
        }
    };

    //Set up request with HTTP method and URL 
    request2.open("POST", "../Server_Side/server_checkout.php");
    request2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    //Send request
    request2.send("func=" + "order" + "&new_order_str=" + new_order_str);

}

//function which diaplays recommended products stored in HTML
//local storage which are based on customer tracking
function recommender(){

    // get products which are recommended based on usual price range of user from local storage
    let price_recommended = JSON.parse(localStorage.Tracker_price_product);

    // checks if array is empty or not
    if (price_recommended.length > 0){

        const div_ele = document.getElementById("tracking-box");

        // remove all HTML which were previously being displayed in DIV
        while(div_ele.lastElementChild){
            div_ele.removeChild(div_ele.lastElementChild);
        }

        // initialising variable containing HTML code to be displayed
        let htmlStr = '';
        htmlStr += '<h4 class="recommended">Recommended For You Based On Your Price Range</h4>';

        // for each recommended products, display its image, name, price and add button
        for (let i = 0; i < price_recommended.length; i++){

            htmlStr += '<p>';
            htmlStr += '    <img src=' + price_recommended[i].image_path +  ' alt="knights">';
            htmlStr += '    <span class="Item-name"> ' + price_recommended[i].deck_name + ' <br> <span class="price-track"> Rs ' + price_recommended[i].price + ' </span> </span>';
            htmlStr += '    <button onclick=\'add_recommendation(' + JSON.stringify(price_recommended[i]) + ')\' id="add" class="add"> Add </button>';
            htmlStr += '</p>';

        }

        htmlStr += '<hr>';
        htmlStr += '<h4 class="recommended">Recommended For You Based On Your Recent Searches</h4>';


        // gets the user's most searched keyword from tracker
        let most_searched = tracker.getTopKeyword();

        // JQeury and AJAX used to display recommenced products based on most seached recent searches
        // server send backs products which match specified keywords
        $.ajax({
            type: "GET",
            url: "../Server_Side/server_checkout.php",
            data: {
                func: "get_recommended",
                keyword: most_searched
            },
            
            //execute upon successfull connection to server
            success: function(data){

                // array of products is not empty
                if (data != "]"){

                    // get parsed version of array of object
                    search_recommended = JSON.parse(data);

                    // if number of returned prducts is less than average, display products matching most searched keyword 
                    if (search_recommended.length <= 5){

                        for (let j = 0; j < search_recommended.length; j++){

                            htmlStr += '<p>';
                            htmlStr += '    <img src=' + search_recommended[j].image_path +  ' alt="knights">';
                            htmlStr += '    <span class="Item-name"> ' + search_recommended[j].deck_name + ' <br> <span class="price-track"> Rs ' + search_recommended[j].price + ' </span> </span>';
                            htmlStr += '    <button onclick=\'add_recommendation(' + JSON.stringify(search_recommended[j]) + ')\' id="add" class="add"> Add </button>';
                            htmlStr += '</p>';
    
                        }
    
                        //insert html code inpage
                        div_ele.innerHTML = htmlStr;

                        // if greater than average this means that most searched keyword has already been erased from memory, hence display 1 high priced product,
                        // 1 middle priced product and 1 low proced product
                    } else {

                        let middle_price_index = Math.round(search_recommended.length/2);

                        for (let j = 0; j < search_recommended.length; j++){

                            if ( j == 0 || j == middle_price_index || j == search_recommended.length-1){

                                htmlStr += '<p>';
                                htmlStr += '    <img src=' + search_recommended[j].image_path +  ' alt="knights">';
                                htmlStr += '    <span class="Item-name"> ' + search_recommended[j].deck_name + ' <br> <span class="price-track"> Rs ' + search_recommended[j].price + ' </span> </span>';
                                htmlStr += '    <button onclick=\'add_recommendation(' + JSON.stringify(search_recommended[j]) + ')\' class="add"> Add </button>';
                                htmlStr += '</p>';

                            }

                        }
    
                        //insert html code in page
                        div_ele.innerHTML = htmlStr;
 
                    }

                    

                }

                
            }
          });


    } else {

        const div_ele = document.getElementById("tracking-box");

        // remove all HTML which were previously being displayed in DIV
        while(div_ele.lastElementChild){
            div_ele.removeChild(div_ele.lastElementChild);
        }

        // initialising variable containing HTML code to be displayed
        let htmlStr = '';
        htmlStr += '<h4 class="recommended">Recommended For You Based On Your Recent Searches</h4>';

        // gets the user's most searched keyword from tracker
        let most_searched = tracker.getTopKeyword();

        // JQeury and AJAX used to display recommenced products based on most seached recent searches
        // server send backs products which match specified keywords
        $.ajax({
            type: "GET",
            url: "../Server_Side/server_checkout.php",
            data: {
                func: "get_recommended",
                keyword: most_searched
            },
            
            //execute upon successfull connection to server
            success: function(data){

                // array of products is not empty
                if (data != "]"){

                    // get parsed version of array of object
                    search_recommended = JSON.parse(data);

                    // if number of returned prducts is less than average, display products matching most searched keyword 
                    if (search_recommended.length <= 5){

                        for (let j = 0; j < search_recommended.length; j++){

                            htmlStr += '<p>';
                            htmlStr += '    <img src=' + search_recommended[j].image_path +  ' alt="knights">';
                            htmlStr += '    <span class="Item-name"> ' + search_recommended[j].deck_name + ' <br> <span class="price-track"> Rs ' + search_recommended[j].price + ' </span> </span>';
                            htmlStr += '    <button onclick=\'add_recommendation(' + JSON.stringify(search_recommended[j]) + ')\' id="add" class="add"> Add </button>';
                            htmlStr += '</p>';
    
                        }
    
                        //insert html code inpage
                        div_ele.innerHTML = htmlStr;

                        // if greater than average this means that most searched keyword has already been erased from memory, hence display 1 high priced product,
                        // 1 middle priced product and 1 low proced product
                    } else {

                        let middle_price_index = Math.round(search_recommended.length/2);

                        for (let j = 0; j < search_recommended.length; j++){

                            if ( j == 0 || j == middle_price_index || j == search_recommended.length-1){

                                htmlStr += '<p>';
                                htmlStr += '    <img src=' + search_recommended[j].image_path +  ' alt="knights">';
                                htmlStr += '    <span class="Item-name"> ' + search_recommended[j].deck_name + ' <br> <span class="price-track"> Rs ' + search_recommended[j].price + ' </span> </span>';
                                htmlStr += '    <button onclick=\'add_recommendation(' + JSON.stringify(search_recommended[j]) + ')\' class="add"> Add </button>';
                                htmlStr += '</p>';

                            }

                        }
    
                        //insert html code in page
                        div_ele.innerHTML = htmlStr;
 
                    }

                    

                }
            }
        })


    }

}

// fucntion to be executed when user clicks the 'add' button of a 
// recommended product. Adds product in mini cart summary, temp cart array,
// and final cart array
function add_recommendation(product_obj){


    //get cart arrays from session storage
    final_cart_arr = JSON.parse(sessionStorage.final_cart);
    let found =  false;

    // check if product is already present in final cart
    for (let j = 0; j < final_cart_arr.length; j++){

        if (final_cart_arr[j].DeckName == product_obj.deck_name){

            //if found set flag
            found = true;

            // only add it if count of item is less than its stock level
            if (final_cart_arr[j].count < final_cart_arr[j].stock){

                let basket_cart_arr = JSON.parse(sessionStorage.cart);

                // to make update apply in cart.
                // renaming keys to the ones used in local storage
                product_obj.id = product_obj._id.$oid;
                delete product_obj._id;
                product_obj.DeckName = product_obj.deck_name;
                delete product_obj.deck_name;
                product_obj.cost = product_obj.price;
                delete product_obj.price;
                product_obj.image = product_obj.image_path;
                delete product_obj.image_path;

                basket_cart_arr.push(product_obj);
                sessionStorage.cart = JSON.stringify(basket_cart_arr);

                final_cart_arr[j].count = final_cart_arr[j].count + 1;
                sessionStorage.final_cart = JSON.stringify(final_cart_arr);

                // display mini cart with updated data
                display_cart_summary();


            }

        }

    }

    // product was not already in basket
    if (found == false){

        let basket_cart_arr = JSON.parse(sessionStorage.cart);

        // to make update apply in cart.
        // renaming keys to the ones used in local storage
        product_obj.id = product_obj._id.$oid;
        delete product_obj._id;
        product_obj.DeckName = product_obj.deck_name;
        delete product_obj.deck_name;
        product_obj.cost = product_obj.price;
        delete product_obj.price;
        product_obj.image = product_obj.image_path;
        delete product_obj.image_path;


        basket_cart_arr.push(product_obj);
        sessionStorage.cart = JSON.stringify(basket_cart_arr);
        product_obj.count = 1;
        final_cart_arr.push(product_obj);
        sessionStorage.final_cart = JSON.stringify(final_cart_arr);

        display_cart_summary();

    }

    

}