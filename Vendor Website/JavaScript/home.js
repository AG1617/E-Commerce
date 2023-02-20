// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;

var search_value;

class Search_Tracker {
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





// get all login ans register button as well as 
// hidden display area div
let login_btn = document.getElementById("login_button");
let register_btn = document.getElementById("register_button");
let display_area = document.getElementById("display_username");

//new instance of tracker
let tracker = new Search_Tracker();

// check if a user is logged in each time window loads
window.onload = check_login();


//fucntion which checks with server if a user is currently logged inb
//returns JSON object of user if true
function check_login(){

    // new request to server to get currently logged user
    let request = new XMLHttpRequest();

    // event handler based upon server response
    request.onload = function() {

        if(request.status === 200){
            let responseData = request.responseText;

            //get user object and parse it
            let current_user = JSON.parse(responseData);

            if(current_user.length > 0){

                //update buttons and actions
                change_and_set_buttons();
                display_area.innerHTML = "Hi " + current_user[0] + " !";

                //begin tracking based on customer price range
                check_orders();

            }
        }

    }

    //Set up request and send it
    request.open("GET", "../Server_Side/server_home.php?func=login");
    request.send();
}


//function which changes the text and actions of the login and register buttons
//if user is logged in
function change_and_set_buttons(){

    //changes text
    login_btn.innerHTML = "Logout";
    register_btn.innerHTML = "Account";

    let old_register_form = document.getElementById("register_form");
    let old_login_form = document.getElementById("login_form");

    //changes action to fucntion logout and to account details page respectively
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

    let new_cart = [];
    let new_object = {};

    //resets all carts in session storage
    sessionStorage.cart = JSON.stringify(new_cart);
    sessionStorage.final_cart = JSON.stringify(new_cart);

    //resets all carts in Local storage
    localStorage.Tracker_price_product = JSON.stringify(new_cart);
    localStorage.TrackerKeywords = JSON.stringify(new_object);

    

    // redirect to login page
    window.location.href="../Client_Side/Login.php";
    

}

// fucntion which reads entered searched values and communicates
//with server to receive and display products which matches keywords
function search(){
    
    //get search value
    search_value = $("#search-bar").val();

    //get filter by (order by) value
    var filter_value = $("#filters").val();


    // check if search value is empty or not
    if (search_value != ""){

        //check if filter value is not 'default'
        if (filter_value == "descending" || filter_value == "ascending"){

            //JQuery and AJAX to request request results in a certain order
            //send search value and ordering type
            $.ajax({
                type: "GET",
                url: "../Server_Side/server_market.php",
                data: {
                    func: "searchAndOrder",
                    search_value: search_value,
                    sort_value: filter_value
                },

                //calls function to display results upon successfull communication with server
                //passes JSON products to function
                success:output_search
              });
    
        } else if (filter_value == "default"){
    
            //JQuery and AJAX to request request results in no particular order
            $.ajax({
                type: "GET",
                url: "../Server_Side/server_market.php",
                data: {
                    func: "search",
                    search_value: search_value,
                    sort_value: filter_value
                },
                success:output_search
              });
    
        }

    }
    
   
}

// fucntion to convert JSON products from server and to 
// display them on the page
function output_search(jsonResults){

    // check if returned array is empty
    if (jsonResults == "]"){

        const div_ele = document.getElementById("product_list");

        // remove all HTML which were previously being displayed in DIV
        while(div_ele.lastElementChild){
            div_ele.removeChild(div_ele.lastElementChild);
        }


        //construct HTML code to display no results found
        let htmlStr = '<h1 id="no_result"> No Result Found !</h1>';

        document.getElementById("product_list").innerHTML = htmlStr;


        // results found
    } else {

        // add valid keyword to Local storage for customer tracking
        tracker.addKeyword(search_value);

        let result_array = JSON.parse(jsonResults);

        // create the html to display
        let htmlStr = '';

        //for each product in result array construct html code
        // to display all info and add to cart button
        for (i = 0; i < result_array.length; i++){

            htmlStr += '<li>';
            htmlStr += '<img src="' + result_array[i].image_path + '"alt="' + result_array[i].deck_name + '">';
            htmlStr += '<h2>' + result_array[i].deck_name + '</h2>';
            htmlStr += '<h3>' + result_array[i].edition + '</h3>';
            htmlStr += '<h3> In Stock : ' + result_array[i].stock + '</h3>';
            htmlStr += '<p> Rs ' + result_array[i].price + '</p>';
            htmlStr += '<p><button onclick=\'add_to_cart("' + result_array[i]._id.$oid + '","' + result_array[i].deck_name 
            + '","' + result_array[i].price + '","' + result_array[i].edition +  '","' + result_array[i].stock + '","' 
            + result_array[i].image_path + '", this)\' class="addcart">Add to Cart</button></p>';
            htmlStr += '</li>';

        }

        const div_ele = document.getElementById("product_list");

        // remove all HTML which were previously being displayed in DIV
        while(div_ele.lastElementChild){
            div_ele.removeChild(div_ele.lastElementChild);
        }


        // insert newly generated HTML code
        document.getElementById("product_list").innerHTML = htmlStr;

    }

    

}


// function to get filtering method and communicate with server
// to get results in price ascending or descending order
function sort(){

    let search_bar = document.getElementById("search-bar");

    let search_value = search_bar.value;

    // if search is not solicited, display all products
    if (search_value == ""){

        let filter = document.getElementById("filters");

        let filter_value = filter.value;

        // new request to server to get all products in an ordered manner
        let request2 = new XMLHttpRequest();


        // event handler based upon server response
        request2.onload = function() {

            if(request2.status === 200){

                //get response from server upon successfull connection
                let responseData = request2.responseText;
    
                //display ordered result
                output_search(responseData);
            }
    
        }

        //only send request if filter by value is valid
        if (filter_value == "descending" || filter_value == "ascending" || filter_value == "default"){

            //Set up request and send it
            request2.open("GET", "../Server_Side/server_market.php?func=Order&sort_value=" + filter_value);
            request2.send();

        } 

        // else call search function to display ordered search results 
    } else if (search_value != "") {

        search();

    }
}

// fucntion to check if temp cart exists
// creates it if does not exist or parses it if it does
// return cart array
function check_cart(){

    let cart_arr;

    if(sessionStorage.cart === undefined || sessionStorage.cart === ""){

        cart_arr = [];

    } else {
        cart_arr = JSON.parse(sessionStorage.cart);
    }

    return cart_arr;


}


//fucntion executed when user clicks on 'add to cart' button,
//passes all porduct info as parameter creates and object out of it
//pushes object onto array only if count has not exeded stock level
function add_to_cart(prod_id, deck_name, price, edition, stock, image_path, button){

    let count = 0;

    //get cart array
    let cart_arr = check_cart();

    //get count of the selected product in array
    for (let x = 0; x < cart_arr.length; x++){

        if (cart_arr[x].id == prod_id){

            count = count + 1;
        }
    }

    //check if current count is less than stock
    if(count < stock){

        //pushes object onto array only if it satisfies condition
        cart_arr.push({id: prod_id, DeckName: deck_name, cost: price, edition: edition, stock: stock, image: image_path});

    }

    // pushes JSON cart back into session storage
    sessionStorage.cart = JSON.stringify(cart_arr);

    //updates button styling
    button.innerHTML = "Added !";
    setTimeout(function(){
        button.innerHTML = "Add to Cart";
      }, 1000);


}

// function to get all of customers order info
// from the server and passes it as a parameter to price tracking function
function check_orders(){

    $.ajax({
        type: "GET",
        url: "../Server_Side/server_market.php",
        data: {
            func: "get_orders",
        },
        // get all current user order from server and passes 
        // to price rage tracking function
        success:check_order_and_price_calculator
      });

}


// function to calculate average spending price range of customer based on 
// his/her past orders to be used to customer tracking and recommendation
function check_order_and_price_calculator(jsonOrders){

    let order_array = JSON.parse(jsonOrders);
    let order_average = [];
    let product_total;
    let product_average;
    let price_total;

    // only if result array from server is not empty
    if (order_array != "]"){

        // for each order
        for ( let j = 0; j < order_array.length; j++){

            product_total = 0;
            product_average = 0;

            // for each product in order
            for ( let x = 0 ; x < order_array[j].products.length ; x++){

                //keep track of the subtotal of the individual products
                product_total = product_total + Number(order_array[j].products[x].price);

            }

            //get product average
            product_average = (product_total / order_array[j].products.length);

            //pushes product average to 2dp onto array to keep history
            order_average.push(product_average.toFixed(2));

        }

        price_total = 0;

        // for every product average 
        for ( let y = 0; y < order_average.length ; y++){

            //keep track of total
            price_total = price_total + Number(order_average[y])

        }

        //calcuate average product spending price
        let price_average = (price_total / order_average.length).toFixed(2);

        // call to tracker function
        price_tracker(Number(price_average));


    }


}

// function to get price range based on average spending price
// and get all products which fall within this range from server
function price_tracker(average_price){

    // price range is +- 20% from average
    let lower_limit = ((80/100) * average_price).toFixed(2);
    let upper_limit = ((120/100) * average_price).toFixed(2);

    // initialise array of recommended products
    let recommended_products = [];


    // JQuery and AJAX to get JSON array of all available products
    $.ajax({
        type: "GET",
        url: "../Server_Side/server_market.php",
        data: {
            func: "get_prods",
        },

        //get all products which fall within price range form products returned from server
        success:function(data){

            //parse JSON response text
            let all_prod_obj = JSON.parse(data);

            for ( let z = 0; z < all_prod_obj.length; z++){

                if (all_prod_obj[z].price >= Number(lower_limit) && all_prod_obj[z].price <= Number(upper_limit)){

                    //is pushed onto array only if price falls within range
                    recommended_products.push(all_prod_obj[z]);
                }
            }

            // stores array onto local storage for later user in checkout
            if(localStorage.Tracker_price_product === undefined){

                localStorage.Tracker_price_product = JSON.stringify(recommended_products);

            } else {

                localStorage.Tracker_price_product = JSON.stringify(recommended_products);
                
            }

        }
      });


}




