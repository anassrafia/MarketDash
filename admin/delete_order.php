<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../src/images/Component/icon_logo.png" type="image/x-icon">
    <title>Document</title>
</head>
<body>

<?php

require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$order_id = $_REQUEST['order_id'];

$req_delete_order = "DELETE FROM orders WHERE order_id = $order_id;";

$cnx->exec($req_delete_order);

header("Location: ./orders.php?check_status=valider");



?>

    
</body>
</html>