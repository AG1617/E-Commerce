<DOCTYPE html>
<html lang="en">
<?php include 'common.php';?>

<head>
    <!-- links to the different icons and fonts used -->
    <?php output_title_and_stylesheet_and_meta("Past Orders Page", "../CSS/Order.css");?>
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<!-- php function to display recurrent navigation bar -->
<?php output_navigation_bar("PAST ORDERS");?>

<!-- php function to output html opening body tag and the main body class -->
<?php output_main_body_and_container("order");?>

                <!-- HTML table to display past order data: date, orderID, item name, price and order cost plus address -->
                <tr>
                    <td>15/01/2023</td>
                    <td>12984</td>
                    <td>Knights Deck</td>
                    <td>340.99</td>
                    <td>1662.87</td>
                    <td>50, Blackberry Street, Wooton</td>
                </tr>
                <tr>
                    <td>15/01/2023</td>
                    <td>12984</td>
                    <td>Knights Deck</td>
                    <td>340.99</td>
                    <td>1662.87</td>
                    <td>50, Blackberry Street, Wooton</td>
                </tr>
                <tr>
                    <td>15/01/2023</td>
                    <td>12984</td>
                    <td>Knights Deck</td>
                    <td>340.99</td>
                    <td>1662.87</td>
                    <td>50, Blackberry Street, Wooton</td>
                </tr>
                <tr>
                    <td>15/01/2023</td>
                    <td>12984</td>
                    <td>Knights Deck</td>
                    <td>340.99</td>
                    <td>1662.87</td>
                    <td>50, Blackberry Street, Wooton</td>
                </tr>
            </table>
        </div>

    </div>
<!-- php function to output body and html closing tags -->
<?php output_footer() ;?>