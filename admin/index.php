<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}


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

        <a href="./logout.php"><i style="cursor : pointer;" class="fa fa-sign-out"></i></a>
        <a href="./"><h2 class="user_name"><i class="fa fa-arrow-down"></i>Welcome <?php echo $_SESSION['username']?></h2></a>
        <i class="fa fa-close" id="fa" style="font-size: 25px;" onclick="showRightSide()"></i>

    </header>

    <div class="right_side">
        <?php
        foreach ($get_user_image as $user_img) {
            $user_image = $user_img['img_src'];
            $link_to_page = $user_img['link_to_page'];

            echo "\n<a href='$link_to_page'>\n<img src='$user_image'>\n</a>\n";
        }
        ?>

        <h2 class="name_user"><?php echo $_SESSION['username']?></h2>

        <ul>
            <details class="Accueil">
                <summary>Accueil <i class="fa fa-home"> </i></summary>
                <li onclick="gérer_les_slides()">gérer les slides</li>
                <li onclick="gérer_les_produits()">gérer les produits</li>
            </details>

            <a style="color:white;text-decoration:none;" target="_blank" href="../"><li>afficher la page <i class="fa fa-eye"> </i></li></a>
            <a target="_blank"  href='./orders.php' style='color : white; text-decoration : none;'><li>commandes <i class="fa fa-first-order"></i></li></a>
            <li onclick='document.querySelector(`.add_admin`).style.display = `block`'>add admin <i class="fa fa-user"></i></li>
            <li onclick='document.querySelector(`.iframe_page`).src = `./setting.php`'>paramètres <i class="fa fa-cog"></i></li>
            <div class="add_admin">
                <i onclick="this.parentNode.style.display = 'none'" class="fa fa-close" style="position :absolute; top:10px;left:10px;color:black;"></i>
                <form method="post" autocomplete="off">
                    <input type="text" placeholder="Add username" name="username"/>
                    <input type="text" placeholder="Add password" name="password"/>
                    <input type="submit" style="cursor:pointer;" value="Add" name="add"/>
                    <?php
                        if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
                            $addusername = $_REQUEST['username'];
                            $addpassword = $_REQUEST['password'];
                            $user_id = rand(9999,9999999);

                            $req_add_userAdmin = "INSERT INTO user_admin VALUES('','$addusername','$addpassword','$user_id')";
                            $cnx->exec($req_add_userAdmin);

                            echo "<script>alert('user a bien été ajouté. username : `$addusername` . password : `$addpassword`')</script>";
                        }
                    ?>
                </form>
            </div>
        </ul>

    </div>

    <iframe class="iframe_page" src="./orders.php" frameborder="0"></iframe>



<script src='admin.js'></script>
</body>

</html>