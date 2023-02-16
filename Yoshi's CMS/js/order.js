



window.onload = get_order();

function get_order(){
    let request1 = new XMLHttpRequest();

    request1.onload = () => {

        if(request1.status === 200){

            output_table(request1.responseText);

        }

    }

    request1.open("GET", "serverorder.php?func=orders");
    request1.send();

}

function output_table(jsonOrders){

    let order_array = JSON.parse(jsonOrders);

    let order_table = document.getElementById("viewproducts");

    for (i = 1; i < order_array.length + 1; i++)
    {
        for (j = 0; j < order_array[i-1].products.length; j++)
        {
            // creating a new row for each order and inserting into HTML table
            let new_row = order_table.insertRow(i);

            // creating new columns for each data to be inserted into the newly created row
            let date = new_row.insertCell(0);
            let order_num = new_row.insertCell(1);
            let customer_num = new_row.insertCell(2);
            let item_name = new_row.insertCell(3);
            let item_cost = new_row.insertCell(4);
            let item_count = new_row.insertCell(5);
            let order_cost = new_row.insertCell(6);
            let address = new_row.insertCell(7);

            date.innerHTML = order_array[i-1].date;
            order_num.innerHTML = order_array[i-1]._id.$oid;
            customer_num.innerHTML = order_array[i-1].customer_id.$oid;
            item_name.innerHTML = order_array[i-1].products[j].name;
            item_cost.innerHTML = order_array[i-1].products[j].price;
            item_count.innerHTML = order_array[i-1].products[j].count;
            order_cost.innerHTML = order_array[i-1].order_cost;
            address.innerHTML = order_array[i-1].delivery_address;

        }
    }
}
