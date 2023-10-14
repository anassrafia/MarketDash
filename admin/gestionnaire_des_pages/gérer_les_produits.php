<?php

require "../../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


$req_get_user_image = "SELECT img_src, Name_image FROM images WHERE categorie = 'slider';";
$get_user_image = $cnx->query($req_get_user_image);


$req_get_products = "SELECT image, price, nom, link, id FROM all_products";
$get_products = $cnx->query($req_get_products);
$get_products1 = $cnx->query($req_get_products);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../mobile.css">
    <link rel="icon" href="../../src/images/Component/icon_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rubik&display=swap" rel="stylesheet">
    <title>gerer les produit</title>
</head>

<body>

    <?php
    require "../header.html"
    ?>


    <div class="container">

        <div class="prducts_edit">
            <h2>ajouter un produit</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Le nom de produit" name="product_name">
                <input type="number" placeholder="prix du produit" name="product_price">
                <input class="file_data" type="file" name="produit_image" accept="image/*" required>
                <input type="submit" class="btn_send" name="add_produit" value="Upload Image">
            </form>
        </div>



        <div class="prducts_edit">
            <h2>supprimer un produit</h2>
            <div class="all_product">
                <?php
                foreach ($get_products as $produit) {
                    $image_produit = $produit['image'];
                    $name_produit = $produit['nom'];
                    $produit_price = $produit['price'];
                    $id = $produit['id'];

                    echo "
                    <div class='infopro select_product_remove' id='$id'>
                        <img src='../../$image_produit' alt='$name_produit'>
                        <div class='product-name'>$name_produit</div>
                    </div>
                    ";
                }
                ?>
            </div>

            <form method="post" enctype="multipart/form-data">
                <input style="display : none;" type="text" name="data_img_delete" id="data_img_delete">
                <input name="btn_delete" type="submit" class="btn_delete" value="supprimer product">
            </form>
        </div>



        <div class="prducts_edit">
            <h2>créer une Landing page</h2>
            <!-- <div class="all_product">
            <?php
                foreach ($get_products1 as $produit1) {
                    $image_produit1 = $produit1['image'];
                    $name_produit1 = $produit1['nom'];
                    $produit_price1 = $produit1['price'];
                    $id1 = $produit1['id'];

                    echo "
                    <div class='infopro select_product_to_add_landing_page' id='$id1'>
                        <img src='../../$image_produit1' alt='$name_produit1'>
                        <div class='product-name'>$name_produit1</div>
                    </div>
                    ";
                }
                ?>
            </div> -->
        </div>



        <div class="prducts_edit">
            <h2>information de produit</h2>
        </div>



    </div>






<script src="manage_product.js"></script>
</body>

</html>

<style>
    .prducts_edit {
        width: 40%;
        height: 20rem;
        border: 1px solid black;
        border-radius: 20px;
        text-align: center;
        margin: auto;
        cursor: default;
        margin-top: 30px;
    }

    .btn_delete{
        cursor: pointer;
    }

    .container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 20px;
    }

    .prducts_edit form input {
        width: 80%;
        height: 40px;
        border-radius: 20px;
        border: 1px solid gray;
        margin-top: 10px;
        font-size: 16px;
        padding-left: 20px;
    }

    .prducts_edit form .file_data {
        background-color: #E5E5E5;
        width: 22%;
        height: 24px;
        border: 3px solid black;
        cursor: pointer;
        padding-left: 0px;
    }

    .prducts_edit form .btn_send {
        cursor: pointer;
    }

    .all_product {
        width: 99%;
        height: 196px;
        /* background-color: red; */
        display: flex;
        justify-content: space-between;
        overflow-x: auto;
        margin: auto;
    }

    .all_product .infopro {
        position: relative;
        border: 1px solid black;
        background-color: white;
        margin-left: 3px;
        margin-right: 3px;
        font-size: 0.6rem;
        width: 105px;
    }

    .all_product .infopro .product-name {}

    .all_product img {
        width: 100px;
    }

    @media screen and (max-width: 768px) and (min-width: 10px) {
        .container {
            display: block;
        }

        .prducts_edit {
            width: 90%;
        }

    }
</style>




<?php
// Assuming you have a database connection established

if (isset($_POST['btn_delete'])) {
    $product_id = $_POST['data_img_delete'];

    // Retrieve the image filename associated with the product
    $sql = "SELECT image FROM all_products WHERE id = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->execute([$product_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $image_filename = $row['image'];

        // Delete the product from the database
        $delete_product_sql = "DELETE FROM all_products WHERE id = ?";
        $delete_product_stmt = $cnx->prepare($delete_product_sql);
        $delete_product_stmt->execute([$product_id]);

        // Construct the full path to the image file
        $image_path = "../../$image_filename";

        // Check if the file exists and is deletable
        if (file_exists($image_path) && is_writable($image_path)) {
            // Delete the image file
            unlink($image_path);
            echo "<script>parent.location = 'redirect.html'</script>";
        } else {
            echo "<script>alert('Image file for product with ID $product_id not found or cannot be deleted.')</script>";
        }
    } else {
        echo "Product with ID $product_id not found.";
    }
}
?>






<!-- add product -->

<?php
if (isset($_POST['add_produit'])) {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // File upload handling
    $target_dir = "src/images/products/";
    $target_file = $target_dir . basename($_FILES["produit_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["produit_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["produit_image"]["size"] > 500000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["produit_image"]["tmp_name"], "../../" . $target_file)) {
            // File uploaded successfully, now insert data into the database
            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("La connexion à la base de données a échoué: " . $conn->connect_error);
            }

            // Prepare and execute the SQL query
            $sql = "INSERT INTO all_products (nom, price, add_to_cart, link, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $add_to_cart = ""; // You can set this value as needed
            $link = ""; // You can set this value as needed

            $stmt->bind_param("sssss", $product_name, $product_price, $add_to_cart, $link, $target_file);

            if ($stmt->execute()) {
                echo "<script>parent.location = 'redirect.html';</script>";
            } else {
                echo "Erreur lors de l'ajout du produit: " . $stmt->error;
            }

            // Close the database connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}
?>