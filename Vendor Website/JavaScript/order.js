// Strict mode is mode for all script
"use strict";

// Global variables used for loops
let i = 0;
let j = 0;

//check if a user is currently logged in each time pages loads
window.onload = check_login();


//function to checks if a customer is currently logged in
//and displays message if not, else displays all past orders
//after making request to server
function check_login(){

    // new request to server to check if user is currently logged in
    let request = new XMLHttpRequest();

     // event handler based upon server response
    request.onload = function() {

        if(request.status === 200){

            // get data from server
            let responseData = request.responseText;

            // if array is empty, display please login fist message in HTML table
            if (responseData == ""){
                let order_table = document.getElementById("order_table");
                let new_row = order_table.insertRow(1);

                let message = new_row.insertCell(0);
                message.colSpan = "7";
                message.innerHTML = "Please Login First !";
                message.style.fontSize = "50px";
            } else {

                //user is currently logged in
                let current_user = JSON.parse(responseData);

                if(current_user.length > 0){
                    //call fucntion to get past orders from server and display in table
                    get_orders();
                }

            }
        }

    }

    //Set up request and send it
    request.open("GET", "../Server_Side/server_order.php?func=login");
    request.send();
}


//function to get past orders of currently from server and display into 
// html table
function get_orders(){


    // new request to server to get customer's past orders
    let request1 = new XMLHttpRequest();

    request1.onload = () => {

        if(request1.status === 200){

            // fucntion call with server response as parameter
            output_table(request1.responseText);

        }

    }
    
    //Set up request and send it
    request1.open("GET", "../Server_Side/server_order.php?func=orders");
    request1.send();

}

//function to display past orders from server into HTML table on page
function output_table(jsonOrders){

    let order_array = JSON.parse(jsonOrders);

    let order_table = document.getElementById("order_table");

    //for each orders in array returned
    for (i = 1; i < order_array.length + 1; i++)
    {
        //for each product bought in order
        for (j = 0; j < order_array[i-1].products.length; j++)
        {
            // creating a new row for each order and inserting into HTML table
            let new_row = order_table.insertRow(i);

            // creating new columns for each data to be inserted into the newly created row
            let date = new_row.insertCell(0);
            let order_num = new_row.insertCell(1);
            let item_name = new_row.insertCell(2);
            let item_cost = new_row.insertCell(3);
            let item_count = new_row.insertCell(4);
            let order_cost = new_row.insertCell(5);
            let address = new_row.insertCell(6);

            date.innerHTML = order_array[i-1].date;
            order_num.innerHTML = order_array[i-1]._id.$oid;
            item_name.innerHTML = order_array[i-1].products[j].name;
            item_cost.innerHTML = order_array[i-1].products[j].price;
            item_count.innerHTML = order_array[i-1].products[j].count;
            order_cost.innerHTML = order_array[i-1].order_cost;
            address.innerHTML = order_array[i-1].delivery_address;

        }

    }

}