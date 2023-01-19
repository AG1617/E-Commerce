<?php
// function to output navigation bar
function output_navigation(){
    echo'
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.cdnfonts.com/css/medula-one" rel="stylesheet">
    <link rel="stylesheet"  media="screen" href="../CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="main.js"></script>
</head>
<body>
    <div class="logo">
        <div><img src="../IMG/logo_final.png"
            width="80"
            height="80"
            ></div>
        <div><h2>Illusionist</h2></div>
        <div class="header">
            <h1>CMS</h1>
        </div>
    </div> 

    <nav>
        <ul>
            <li><a href ="index.php">HOME</a></li>
            <li><a href ="addprod.php">ADD PRODUCT</a></li>
            <li><a href ="#">LIST PRODUCT</a></li>
            <li><a href ="editprod.php">EDIT PRODUCT</a></li>
            <li><a href ="deleteprod.php">DELETE PRODUCT</a></li>
            <li><a href ="vieworder.php">VIEW ORDER</a></li>
            <li><a href ="deleteorder.php">DELETE ORDER</a></li>
        </ul>
    </nav>';

}