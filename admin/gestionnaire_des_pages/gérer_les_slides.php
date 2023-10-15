<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../admin/login.php");
}
?>

<?php

require "../../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$req_get_user_image = "SELECT img_src, Name_image FROM images WHERE categorie = 'slider';";

$get_user_image = $cnx->query($req_get_user_image);

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
    <title>gerer les slide</title>
</head>

<body>

    <?php
        require "../header.html"
    ?>

    <div class="container">
        <div class="add_slider">
            <form method="post" enctype="multipart/form-data">
                <h2><i class="fa fa-plus"></i> ajouter un slider</h2>
                <input type="text" name="link_to_page" id="inputField" placeholder="slider name" required
                    autocomplete="off" onchange="transformValue()">
                <input class="upload_btn" type="file" name="image" accept="image/*" required>
                <input class="btn" type="submit" value="Upload Image">
            </form>
        </div>

        <div class="add_slider">
            <form method="post" enctype="multipart/form-data">
                <h2><i class="fa fa-trash"></i> supprimer un slider</h2>
                <input style="display : none;" type="text" name="data_img_delete" id="data_img_delete">

                <div class="select_sliders remove_slider">
                    <?php
                    foreach ($get_user_image as $user_img) {
                        $user_image = $user_img['img_src'];
                        $Name_image = $user_img['Name_image'];

                        echo "<img class='$Name_image' src='../../$user_image' 
                            onclick='
                                document.querySelector(`#data_img_delete`).value = this.className;
                                this.style.border = `2px solid red`;
                            '>";
                    }
                    ?>
                </div>

                <input name="btn_delete" type="submit" value="supprimer Image">
            </form>
        </div>
    </div>






    <script>
        function transformValue() {
            // Get the input value
            var inputValue = document.getElementById('inputField').value;

            // Replace spaces with underscores and make the string lowercase
            var transformedValue = inputValue.replace(/ /g, '_').toLowerCase();

            // Update the transformed value in the HTML
            document.getElementById('inputField').value = transformedValue;
        }
    </script>

</body>

</html>

<style>
    .container {
        width: 100%;
        height: 19rem;
        display: flex;
        margin: auto;
        margin-top: 30px;
        justify-content: space-around;
    }

    .add_slider {
        width: 40%;
        height: auto;
        color: black;
        border: 1px solid black;
        border-radius: 20px;
        padding: 20px;

    }

    .add_slider form {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .add_slider form input {
        width: 80%;
        height: 40px;
        margin-top: 20px;
    }

    .add_slider form .btn {
        cursor: pointer;
        width: 40%;
    }

    .select_sliders img {
        max-width: 200px;
        height: 5.7rem;
        margin-right: 20px;
    }

    .remove_slider {
        overflow-x: auto;
        width: 100%;
        height: auto;
        display: flex;
    }

    @media screen and (max-width: 768px) and (min-width: 10px) {
        .container {
            width: 100%;
            height: 19rem;
            display: block;
            margin: auto;
            margin-top: 30px;
            justify-content: space-around;
        }

        .container .add_slider {
            width: 87%;
            margin: auto;
            margin-top: 20px;
        }

    }
</style>





<?php
/* delete slider */

if (isset($_REQUEST['btn_delete'])) {
    $data_img_delete = $_REQUEST['data_img_delete'];

    // Get the image file path from the database
    $sql = "SELECT `img_src` FROM `images` WHERE `Name_image` = :data_img_delete";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':data_img_delete', $data_img_delete, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $img_src = $row['img_src'];

        // Delete the image file from the server
        if (unlink("../../" . $img_src)) {
            // Delete the database record
            $req_img_delete = "DELETE FROM `images` WHERE `Name_image` = :data_img_delete";
            $stmt = $cnx->prepare($req_img_delete);
            $stmt->bindParam(':data_img_delete', $data_img_delete, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<script>alert('L'image a été supprimée avec succès'); parent.location = 'redirect.html';</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression de l'image');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors de la suppression de l'image sur le serveur');</script>";
        }
    } else {
        echo "<script>alert('L'image n'a pas été trouvée dans la base de données');</script>";
    }
    echo "<script>parent.location = 'redirect.html';</script></script>";
}
?>



<?php
// Database configuration
$hostname = $host;
$usernames = $username;
$passwords = $password;
$database = $dbname;

// Create a database connection
$conn = new mysqli($hostname, $usernames, $passwords, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $link_to_page = $_POST["link_to_page"];

    // Handle image upload
    $targetDir = "src/images/Home_page_slide/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../../" . $targetFile)) {
        // Insert image information into the database
        $img_src = $targetFile;
        $name_image = "/src/images/Home_page_slide/" . $_FILES["image"]["name"];
        $price = "";
        $categorie = "slider";

        $sql = "INSERT INTO images (img_src, link_to_page, Name_image, price, categorie) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $img_src, $link_to_page, $name_image, $price, $categorie);

        if ($stmt->execute()) {
            echo "<script>parent.location = ''</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }
}

// Close the database connection
$conn->close();
?>