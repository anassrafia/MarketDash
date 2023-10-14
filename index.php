<?php

require "./src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


$req_get_sliders = "SELECT img_src, link_to_page FROM images WHERE categorie = 'slider';";
$get_sliders = $cnx->query($req_get_sliders);


$req_get_products = "SELECT image, price, nom, link, id FROM all_products";
$get_products = $cnx->query($req_get_products);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="./src/css/laptop.css">
    <link rel="stylesheet" href="./src/css/mobile.css">
    <link rel="icon" href="./src/images/Component/icon_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rubik&display=swap" rel="stylesheet">
    <title>Vie Store</title>
</head>

<script>



</script>

<body>


    <header>

        <a href=""><img src="./src/images/Component/logo_l.png" alt="vie store logo" class="logo" /></a>

        <strong class="principal">Principal</strong>

        <div class="the_shopping_cart">

            <i class="fa fa-search" id="search"></i>

            <div class="panier">
                <span class="balance">$ 100</span>
                <span class="shop_cart" onclick="document.querySelector('.my_cart').style.display = 'flex';"><i
                        class="fa fa-shopping-cart"></i></span>
                <span class="bars"><i class="fa fa-bars"></i></span>
            </div>

        </div>

    </header>


    <div class='img_slider'>
        <?php
        foreach ($get_sliders as $slider) {
            $image_slider = $slider['img_src'];
            $link_to_page = $slider['link_to_page'];

            echo "\n<a href='$link_to_page'>\n<img src='$image_slider'>\n</a>\n";
        }
        ?>
    </div>

    <h2 class="first_title">Shop</h2>


    <div class="container">



        <?php
        foreach ($get_products as $produit) {
            $image_produit = $produit['image'];
            $name_produit = $produit['nom'];
            $produit_price = $produit['price'];
            $produit_id = $produit['id'];

            echo "
            <div class='product'>
            <a href='buy_product/index.php?id=$produit_id' onmouseenter='this.nextElementSibling.style.display = `block`' onmouseout='this.nextElementSibling.style.display = `none`'>
                <img src='./$image_produit' alt='$name_produit'>
                <div class='product-name'>$name_produit</div>
                <div class='product-price'>$ $produit_price</div>
            </a>
            <div onmouseenter='this.style.display = `block`' class='add-to-cart' onclick='add_to_cart_$produit_id();'><i class='fa fa-shopping-bag'></i></div>
            </div>

            <script>
                function add_to_cart_$produit_id() {
                    var all_pro_added = `
                    <div id='$produit_id' class='pro_added'>
                    <img src='./$image_produit' alt=''>
                    <div class='pro_added_info'>
                        <h2 class='pro_added_title'>$name_produit</h2>
                        <strong class='pro_added_price'>$ $produit_price</strong><br>
                        <a href='buy_product/index.php?id=$produit_id'><button>Commander</button></a>
                        <i id='delete_item'  onclick='this.parentNode.parentNode.remove();' class='fa fa-trash'></i>
                    </div>
                    </div>
                    `;

                    localStorage.setItem(`cart_id_$produit_id`, all_pro_added);

                    const keys = Object.keys(localStorage);
                    const the_cart = document.querySelector('.the_cart');

                    // Clear the existing content of the_cart
                    the_cart.innerHTML = '';

                    keys.forEach((key) => {
                        const value = localStorage.getItem(key);
                        // Append the new value to the_cart
                        the_cart.innerHTML += value;
                    });



                }


            </script>
            
            ";
        }
        ?>






        <section class="my_cart">

            <i id="hide_my_cart" onclick="this.parentNode.style.display = 'none'" class="fa fa-close"></i>

            <div class="the_cart">
                <script>
                    const keys = Object.keys(localStorage);

                    keys.forEach((key) => {
                        const value = localStorage.getItem(key);  
                        document.write(value)                  
                    })
                </script>
            </div>

        </section>







        <!-- $produit_id -->

    </div><br><br><br>

    <footer>
        <div class="footer-logo">
            <img src="./src/images/Component/logo_d.png" alt="Vie Store Logo">
        </div>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Connect</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
        </div>
    </footer>




    <script src="./src/js/main.js"></script>
    <script>

    </script>
</body>

</html>