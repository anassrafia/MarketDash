<?php

require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$req_get_user_image = "SELECT img_src, link_to_page FROM images WHERE categorie = 'user_image';";

$get_user_image = $cnx->query($req_get_user_image);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mobile.css">
    <link rel="icon" href="../src/images/Component/icon_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rubik&display=swap" rel="stylesheet">
    <title>Admin / dashboard</title>
</head>

<body>

    <header>

        <a href="../"><i style="cursor : pointer;" class="fa fa-home"></i></a>
        <h2 class="user_name"><i class="fa fa-arrow-down"></i> Admin</h2>
        <i class="fa fa-bars" style="font-size: 25px;" onclick="show_right_side()"></i>

    </header>

    <div class="right_side">
        <?php
        foreach ($get_user_image as $user_img) {
            $user_image = $user_img['img_src'];
            $link_to_page = $user_img['link_to_page'];

            echo "\n<a href='$link_to_page'>\n<img src='$user_image'>\n</a>\n";
        }
        ?>

        <h2 class="name_user">Admin</h2>

        <ul>
            <details class="Accueil">
                <summary>Accueil <i class="fa fa-home"> </i></summary>
                <li onclick="gérer_les_slides()">gérer les slides</li>
                <li onclick="gérer_les_produits()">gérer les produits</li>
            </details>

            <li onclick="show_iframe_page()">afficher la page <i class="fa fa-eye"> </i></li>
            <li>tableau de bord</li>
            <li>tableau de bord</li>

        </ul>

    </div>

    <iframe id="home_iframe" src="../index.php" class="iframe_page" frameborder="0"></iframe>



<script src='admin.js'></script>
</body>

</html>