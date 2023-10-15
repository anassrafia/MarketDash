<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../src/images/Component/icon_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rubik&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <strong class="errorMess"
            style="color:red;display : none;text-align:center;position:relative;top:-10px;">Invalid
            password/username</strong>
        <form method="post" autocomplete="off">
            <div class="textbox">
                <i class="fa fa-user" aria-hidden="true"></i>
                <input type="text" placeholder="Username" name="username" required autocomplete="off">
            </div>
            <div class="textbox">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <input type="password" placeholder="Password" name="password" required autocomplete="off">
            </div>
            <input type="submit" class="btn" value="Login">
        </form>
    </div>
</body>

</html>

<?php
require "../src/cnx/index.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $usernamesss = $_POST['username'];
    $passwordsss = $_POST['password'];

    // Establish a database connection using the variables from the included file
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform a database query to retrieve the user's data
    $query = "SELECT username, password FROM user_admin WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usernamesss);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows == 1) {
        $stmt->bind_result($dbUsername, $dbPassword);
        $stmt->fetch();

        // Check if the entered password matches the plain text password from the database
        if ($passwordsss == $dbPassword) {
            session_start();
            $_SESSION['username'] = $dbUsername;
            header("Location: ./");
        } else {
            echo "<script>document.querySelector('.errorMess').style.display = 'block';</script>";
        }
    } else {
        echo "<script>document.querySelector('.errorMess').style.display = 'block';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>




<style>
    body {
        margin: 0;
        padding: 0;
        background: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-box {
        width: 300px;
        padding: 20px;
        position: relative;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .login-box h2 {
        margin: 0 0 20px;
        padding: 0;
        color: #333;
    }

    .textbox {
        position: relative;
        margin-bottom: 30px;
    }

    .textbox i {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #777;
    }

    .textbox input {
        width: 92%;
        padding: 10px;
        border: none;
        outline: none;
        background: #f2f2f2;
        color: #333;
        text-align: center
    }

    .btn {
        width: 100%;
        background: #333;
        border: none;
        padding: 10px;
        color: #fff;
        cursor: pointer;
    }
</style>