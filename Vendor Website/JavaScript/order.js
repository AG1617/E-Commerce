// Strict mode is mode for all script
"use strict";

// Global variable i used for loops
let i = 0;
let j = 0;

window.onload = check_login();

function check_login(){

    let request = new XMLHttpRequest();

    request.onload = function() {

        if(request.status === 200){
            let responseData = request.responseText;

            if (responseData == ""){
                let order_table = document.getElementById("order_table");
                let new_row = order_table.insertRow(1);

                let message = new_row.insertCell(0);
                message.colSpan = "6";
                message.innerHTML = "Please Login First !";
                message.style.fontSize = "50px";
            } else {

                let current_user = JSON.parse(responseData);

                if(current_user.length > 0){
                    get_orders();
                }

            }
        }

    }

    request.open("GET", "server_order.php?func=login");
    request.send();
}

function get_orders(){

    let request1 = new XMLHttpRequest();

    request1.onload = () => {

        if(request1.status === 200){

            output_table(request1.responseText);

        }

    }

    request1.open("GET", "server_order.php?func=orders");
    request1.send();

}

function output_table(jsonOrders){

    let order_array = JSON.parse(jsonOrders);

    let order_table = document.getElementById("order_table");

    for (i = 1; i < order_array.length + 1; i++)
    {
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