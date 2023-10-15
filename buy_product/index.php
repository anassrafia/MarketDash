<?php

require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$req_get_info_products = "SELECT image, price, nom, id FROM all_products WHERE id = ''";
$get_products_info = $cnx->query($req_get_info_products);


if (isset($_GET['id'])) {
    $produit_id = $_GET['id'];
} else {
    die("<script>alert('product not found!');parent.location = '../'</script>");
}

try {
    $stmt = $cnx->prepare("SELECT * FROM all_products WHERE id = :id");
    $stmt->bindParam(':id', $produit_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the data as an associative array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$req_get_products = "SELECT image, price, nom, link, id FROM all_products";
$get_products = $cnx->query($req_get_products);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../src/css/laptop.css">
    <link rel="stylesheet" href="../src/css/mobile.css">
    <link rel="icon" href="../src/images/Component/icon_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rubik&display=swap" rel="stylesheet">
    <title>Buy Product</title>
</head>

<body onload="if(localStorage.getItem('total') == null){document.querySelector('.balance').textContent = 'Dh 0'}">


    <header>

        <a href="../"><img src="../src/images/Component/logo_l.png" alt="vie store logo" class="logo" /></a>

        <strong class="principal">Principal</strong>

        <div class="the_shopping_cart">

            <div class="panier">
                <span class="balance">
                    <script>
                        document.write('Dh ' + localStorage.getItem('total'));
                    </script>
                </span>
                <span class="shop_cart" onclick="document.querySelector('.my_cart').style.display = 'flex';"><i
                        class="fa fa-shopping-cart"></i></span>
            </div>

        </div>

    </header>



    <div class="container">
        <div class="product-image">
            <img src="../<?php echo "{$product['image']}"; ?>" alt="Product Image">
        </div>
        <div class="product-details">
            <h2>
                <?php echo "{$product['nom']}"; ?>
            </h2>
            <p>Price: Dh
                <?php echo "{$product['price']}"; ?>
            </p>
            <form method="POST">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <button type="submit">Buy Now</button>
            </form>
        </div>
    </div>

    <?php

    if (isset($_REQUEST['name'])) {
        $id_pro = $product['id'];
        $Name = $_REQUEST['name'];
        $Phone = $_REQUEST['phone'];
        $Quantite = $_REQUEST['quantity'];
        $Order_date = date("m/d/Y");
        $ville = $_REQUEST['ville'];
        $Total = $product['price'] * $Quantite;
        $order_id = rand(9999, 999999);
        $statue = 'en attente';

        $req_buy_pro = "INSERT INTO `orders` VALUES ('$Name','$Phone','$Quantite','$Order_date','$ville','$Total','$statue', '$id_pro', '$order_id')";
        $cnx->exec($req_buy_pro);
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


    <script src="../src/js/main.js"></script>
</body>

</html>