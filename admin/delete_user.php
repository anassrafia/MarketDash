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
    <title>delete user</title>
</head>
<body>

<?php

require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$user_id = $_REQUEST['user_id'];

$req_delete_user = "DELETE FROM user_admin WHERE user_id = $user_id;";

$cnx->exec($req_delete_user);

header("Location: ./setting.php");


?>

    
</body>
</html>