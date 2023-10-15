<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}
?>

<?php

require "../src/cnx/index.php";
$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$check = $_REQUEST['check'];
$order_id = $_REQUEST['order_id'];

$req_update_statue = "UPDATE orders SET Status = '$check' WHERE order_id = '$order_id';";
$cnx->exec($req_update_statue);

header("Location: ./orders.php?check_status=$check");


?>