// Strict mode is mode for all script
"use strict";

// Global variables used for loops
let i = 0;

let j = 0;

let k = 0;

// get all elements of class 'items' from page
let current_prod_collection = document.getElementsByClassName("items");

let cart_arr;

// get cart temp cart contents from session storage
if (sessionStorage.cart != undefined){

    cart_arr = JSON.parse(sessionStorage.cart);
} else {
    cart_arr = [];
}


// final cart array of objects which contains only 1 instance of 
// an item with a field containing the count of that item.
let correct_arr = get_prod_count(cart_arr);


// always display cart content upon page loading
window.onload = display_cart();
    

// fucntion which checks content of array of objects
// and displays it to customer
function display_cart(){

    // check if cart is empty or not
    if (cart_arr.length == 0){

        // gets all data output fields from page and displays empty values
        let total = 0;

        let total_count = document.getElementById("total_amount");

        total_count.innerHTML = "Rs " + total.toFixed(2);

        let item_count = document.getElementById("item_count");

        item_count.innerHTML = correct_arr.length + " items";
        
    
        // if cart is not empty
    } else {
    
        // remove all elements that were previously being displayed
        while (current_prod_collection.length > 0){
    
            var prod = current_prod_collection[0];
            prod.parentNode.removeChild(prod);
        
        }
    
        // initialising variable containing HTML code to be displayed
        let htmlStr = '';

        // initialising subtotal of all items to be bought
        let total = 0;
    
        // for each objects (products) in array (cart)
        for (i = 0; i < correct_arr.length; i++){
    
            // constructs HTML code to be displayed with all product information
            htmlStr += '<div class="items">';
            htmlStr += '<div class="image"><img src="' + correct_arr[i].image + '" style="height:120px" /></div>';
            htmlStr += '<div class="details"><h1 class="deck-name" id="deck-name">' + correct_arr[i].DeckName + '</h1>';
            htmlStr += '<h3 class="press-type"id="press-type">' + correct_arr[i].edition + '</h3></div>';
            htmlStr += '<div class="count-selector">';
            htmlStr += '<button onclick=\'instance_change("' + correct_arr[i].id + '", this)\' class="btn" value="add">+</button><div class="count">' + correct_arr[i].count + '</div><button onclick=\'instance_change("' + correct_arr[i].id + '", this)\' class="btn" value="minus">-</button></div>';
            htmlStr += '<div class="price"><div class="amount">Rs ' + (correct_arr[i].cost * correct_arr[i].count).toFixed(2) + '</div><div class="remove"><u onclick=\'remove_one("' + correct_arr[i].id + '")\'>Remove</u></div> </div> ';
            htmlStr += '</div>';

            // incrementing subtotal for each product
            total = total + (correct_arr[i].cost * correct_arr[i].count)
    
        }
    
        // remove all elements that were previously being displayed
        // and displays newly contructed HTML code
        let after_element = document.getElementById("frame-name");
    
        after_element.insertAdjacentHTML("afterend", htmlStr);

        let total_count = document.getElementById("total_amount");

        // display subtotal rounded to 2 decimal places
        total_count.innerHTML = "Rs " + total.toFixed(2);

        let item_count = document.getElementById("item_count");

        item_count.innerHTML = correct_arr.length + " items";
    
    }

}

// fucntion which removes a single item from cart when button is clicked. 
// Updates subtotal and number of items dislayed
// recieves the product id as parameter
function remove_one(current_id){

    //loop to find product in final version of cart array
    for (let z = 0; z < correct_arr.length; z++){

        // if found
        if (correct_arr[z].id == current_id){

            // remove entire object from array
            correct_arr.splice(z,1);

            // same operation but in temp cart array
            for (let t = 0; t < cart_arr.length; t++){

                if (current_id == cart_arr[t].id){

                    cart_arr.splice(t,1);

                    // store updated version back in session storage
                    sessionStorage.cart = JSON.stringify(cart_arr);

                }

            }

            
        }
    }

    // if not products were present
    if (correct_arr.length == 0){

        // empty entire cart
        remove_all();
    }

    // display new contents of cart
    display_cart();

}


// function which removes all products from cart array and final cart array
function remove_all(){

    // clears final cart raay
    correct_arr.splice(0, correct_arr.length);

    //displays content of cart
    display_cart();

    // resets temp cart array in HTML session storage
    let arr = JSON.parse(sessionStorage.cart);

    arr = [];

    sessionStorage.cart = JSON.stringify(arr);
}

// function which allows user to change the number of instances of a product he wishes to buy
// get the id of the specific button and the button clicked as parameter
function instance_change(current_id,button){

    // get operation to be performed (add or minus)
    var operation = button.getAttribute("value");


    if (operation == "add"){

        //loop through final version of cart to find specific product
        for (let y = 0; y < correct_arr.length; y++){

            if (correct_arr[y].id == current_id){

                // only increment count if current count is less than stock available
                if (correct_arr[y].count < correct_arr[y].stock){

                    correct_arr[y].count = correct_arr[y].count + 1;

                    let occurence = 0;
                    let current_object;

                    // make consequent change in the temp cart array
                    for (var ele of cart_arr){

                        if(correct_arr[y].id == ele.id){

                            occurence++;
                            current_object = ele;

                        }
                    }

                    if (occurence < correct_arr[y].stock){

                        cart_arr.push(current_object);

                        sessionStorage.cart = JSON.stringify(cart_arr);

                    }

                }

            }
        }

        // display content of cart after update
        display_cart();

    } else if (operation == "minus"){


        // same opeartion as shown above
        for (let y = 0; y < correct_arr.length; y++){

            if (correct_arr[y].id == current_id){

                // only update count if current count is greater than 1
                // if user wishes to make remove product (count 0) then removeOne fucntion
                // should be called
                if (correct_arr[y].count > 1){

                    correct_arr[y].count = correct_arr[y].count - 1;

                    let occurence = 0;
                    let current_object_index;

                    // make consequent change in temp cart array
                    for (var ele of cart_arr){

                        if(correct_arr[y].id == ele.id){

                            occurence++;
                            current_object_index = cart_arr.indexOf(ele);

                        }
                    }

                    if (occurence > 1){

                        cart_arr.splice(current_object_index,1);

                        sessionStorage.cart = JSON.stringify(cart_arr);

                    }

                }

            }
        }

        display_cart();

    }
}

// fucntion which loops through the temp cart array and creates a final
// version of cart with only a unique instance of product (object) and each
// object has a field which specified the number of instances customer wishes to buy
function get_prod_count(arr){

    let unique_id;
    let check_arr = [];
    let current_prod_id;
    let num_occurence = 0;

    // for each item in the temp cart array
    for (let x = 0; x < arr.length; x++){

        // get id of object
        unique_id = arr[x].id;

        // check if selected object is already present or not in final cart array
        if (check_arr.filter( e => e.id === unique_id).length > 0){

        } else {
            // pushes object onto final cart array only if not already present
            check_arr.push(arr[x]);
        }
    }



    // loop though the contents of final cart array and check
    // number of time that item is present in the temp cart array
    // thus getting number of instances the customer wishes to buy for each product
    for(j = 0; j < check_arr.length; j++){

        num_occurence = 0;

        current_prod_id = check_arr[j].id;

        for(k = 0; k < arr.length; k++){

            if (current_prod_id == arr[k].id){

                num_occurence = num_occurence + 1;

            }

        }

        check_arr[j].count = num_occurence;


    }

    // return final cart array
    return check_arr;

}

// fucntion which allows access to checkout page only
// if user is currently logged in
function checkout(){

    let final_cart = correct_arr;


    let reset_cart = sessionStorage.final_cart;

    reset_cart = [];

    sessionStorage.final_cart = JSON.stringify(reset_cart);
   
    // if cart is not empty then put final cart in HTML session storage
    if(correct_arr.length > 0){

        sessionStorage.final_cart = JSON.stringify(final_cart);

        // JQuery and AJAX used to check if user is currently logged in
        $.ajax({
            type: "GET",
            url: "../Server_Side/server_cart.php",
            data: {
                func: "getLogin"
            }, 
            // on successfull conection to server
            success:function(data){

                // user is logged in
                if (data != ""){

                    // parse JSON current user object recieved from server
                    let current_user = JSON.parse(data);
                    if(current_user.length > 0){

                        // access checkout page 
                        window.location.href = "http://localhost/Customer-Facing/PHP/Client_Side/Checkout.php";
                    }

                    // user is not logged in
                } else {
                    // displays error message
                    alert("Please log in first.");
                }
                
            }
          });

    }
}



