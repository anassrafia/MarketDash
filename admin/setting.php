<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}


require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$req_get_users = "SELECT id, username, password, user_id FROM user_admin";

$get_user = $cnx->query($req_get_users);

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
    <title>setting</title>
</head>

<body>

    <h2>Gerer les user</h2>

    <table>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>password</th>
            <th>user_id</th>
            <th>supprimer user</th>
        </tr>

        <?php
        foreach ($get_user as $user) {
            $ids = $user['id'];
            $usernamess = $user['username'];
            $passwordss = $user['password'];
            $user_ids = $user['user_id'];

            echo "
            <tr>
                <td>$ids</td>
                <td>$usernamess</td>
                <td>******* <i onclick='this.parentNode.textContent = $passwordss' class='fa fa-eye' style='cursor : pointer;'></i></td>
                <td>$user_ids</td>
                <td><a href='./delete_user.php?user_id=$user_ids'><i style='cursor:pointer' class='fa fa-trash'></i></a></td>
            </tr>
            ";
        }
        ?>

    </table>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: white;
        }

        body {
            padding: 20px;
        }
    </style>


</body>

</html>