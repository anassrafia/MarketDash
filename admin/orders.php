<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}
?>

<?php

require "../src/cnx/index.php";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


$req_get_orders = "SELECT `product_id`, `Name`, `phone`, `Quantite`, `Order_date`, `ville`, `Total`, `Status`, `order_id` FROM `orders`;";
$get_orders = $cnx->query($req_get_orders);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../src/images/Component/icon_logo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body bgcolor="#202841" style="font-family : arial; padding : 20px;">

    <h1 style="color : white; cursor : default">Tableau de bord</h1>
    <h4 style="color : white; cursor : default">Tableau de bord pour suivre les commandes des clients...</h4>

    <section class="dashboard_orders">
        <?php
        $result = $cnx->query("SELECT COUNT(*) FROM orders");
        $count = $result->fetchColumn();
        $result->closeCursor();
        ?>

        <!-- get all en attente data -->

        <!-- <?php
        $get_en_attente = $cnx->query("SELECT COUNT(*) FROM orders WHERE Status = 'en attente';");
        $get_en_attente_orders = $get_en_attente->fetchColumn();
        $get_en_attente->closeCursor();
        ?> -->

        <div>
            <h1><span>
                    <?php echo $count; ?>
                </span> Tous les ordres</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="2em"
                viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <style>
                    svg {
                        fill: #ffffff
                    }
                </style>
                <path
                    d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z" />
            </svg>
        </div>

        <div class="div_select">
            <h1>

                <form method="get">
                    <select name="check_status" style="width : 70%;height:35px;display:block;margin : auto;"
                        onchange="this.form.submit()">
                        <option>Status</option>
                        <option value="en attente" <?php if (isset($_REQUEST['check_status']) && $_REQUEST['check_status'] === "en attente")
                            echo "selected"; ?>>les ordres en attente</option>
                        <option value="valider" <?php if (isset($_REQUEST['check_status']) && $_REQUEST['check_status'] === "valider")
                            echo "selected"; ?>>les ordres valider</option>
                        <option value="annuler" <?php if (isset($_REQUEST['check_status']) && $_REQUEST['check_status'] === "annuler")
                            echo "selected"; ?>>les ordres annuler</option>
                    </select>
                </form>
            </h1>

            <h1 style="text-align : center;margin-right : 10px;font-size:50px;">
                <?php
                if (isset($_REQUEST['check_status'])) {
                    $check_status = $_REQUEST['check_status'];
                    $stmt = $cnx->prepare("SELECT COUNT(*) FROM orders WHERE Status = :check_status");
                    $stmt->bindParam(':check_status', $check_status);
                    $stmt->execute();
                    $get_check_status_orders = $stmt->fetchColumn();
                    echo $get_check_status_orders;
                } else {
                    echo '0';
                }
                ?>
            </h1>

        </div>

        <div>
            <h1><span>
                    <?php
                    $Quantite_totale = $cnx->query("SELECT SUM(Quantite) AS Quantite FROM orders");
                    $check_Quantite = $Quantite_totale->fetch();
                    $totalQuantite = $check_Quantite['Quantite'];
                    echo $totalQuantite;
                    ?>
                </span> Quantite Total</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="2em"
                viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <style>
                    svg {
                        fill: #ffffff
                    }
                </style>
                <path
                    d="M248 0H208c-26.5 0-48 21.5-48 48V160c0 35.3 28.7 64 64 64H352c35.3 0 64-28.7 64-64V48c0-26.5-21.5-48-48-48H328V80c0 8.8-7.2 16-16 16H264c-8.8 0-16-7.2-16-16V0zM64 256c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H224c35.3 0 64-28.7 64-64V320c0-35.3-28.7-64-64-64H184v80c0 8.8-7.2 16-16 16H120c-8.8 0-16-7.2-16-16V256H64zM352 512H512c35.3 0 64-28.7 64-64V320c0-35.3-28.7-64-64-64H472v80c0 8.8-7.2 16-16 16H408c-8.8 0-16-7.2-16-16V256H352c-15 0-28.8 5.1-39.7 13.8c4.9 10.4 7.7 22 7.7 34.2V464c0 12.2-2.8 23.8-7.7 34.2C323.2 506.9 337 512 352 512z" />
            </svg>
        </div>

        <div>
            <h1><span>
                    <?php
                    $Revenu_totale = $cnx->query("SELECT SUM(Total) AS Total FROM orders WHERE Status = 'valider';");
                    $check_Revenu = $Revenu_totale->fetch();
                    $totalRevenu = $check_Revenu['Total'];
                    echo $totalRevenu . " Dh";
                    ?>

                </span> Revenu total</h1>
            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <style>
                    svg {
                        fill: #ffffff
                    }
                </style>
                <path
                    d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V424c0 11 9 20 20 20s20-9 20-20V410.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l0 0-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V216z" />
            </svg>
        </div>

    </section>

    <div class="table_title">
        <h3>use the board to add orders and track their progress</h3>
        <div>

            <button onclick="parent.location = './'"><svg xmlns="http://www.w3.org/2000/svg" height="1.5em"
                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <style>
                        svg {
                            fill: #ffffff
                        }
                    </style>
                    <path
                        d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                </svg></button>

        </div>
    </div>

    <article>
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Quantite</th>
                <th>Order date</th>
                <th>ville</th>
                <th>Total</th>
                <th>Status</th>
                <th>Product id</th>
                <th>Check Status</th>
                <th>Supprimer order</th>
            </tr>

            <?php
            foreach ($get_orders as $order) {
                $product_id = $order['product_id'];
                $Name = $order['Name'];
                $phone = $order['phone'];
                $Quantite = $order['Quantite'];
                $Order_date = $order['Order_date'];
                $ville = $order['ville'];
                $Total = $order['Total'];
                $order_id = $order['order_id'];
                $Status = $order['Status'];

                echo "<tr class='$Status'>
            <td>$Name</td>
            <td>$phone</td>
            <td>$Quantite</td>
            <td>$Order_date</td>
            <td>$ville</td>
            <td>$Total Dh</td>
            <td>$Status</td>
            <td><a style='color:white;' href='../buy_product/index.php?id=$product_id'>$product_id</a></td>
            <td>
                <form method='get' action='./update_statue.php'>
                    <select name='check' style='display:block; margin:auto;' onchange='this.form.submit();'>
                        <option>Status</option>
                        <option value='en attente'>en attente</option>
                        <option value='valider'>valider</option>
                        <option value='annuler'>annuler</option>
                    </select>
                    <input type='hidden' name='order_id' value='$order_id'>
                </form>
            </td>
            <td><a style='color:white;' href='./delete_order.php?order_id=$order_id'><i class='fa fa-trash' style='font-size : 18px;cursor:pointer;'></i></a></td>
            </tr>";
            }
            ?>


        </table>
    </article>



</body>

</html>

<style>
    .dashboard_orders {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .valider {
        background-color: #37AB51;
    }

    .annuler {
        background-color: #CD4C4C;
    }

    .attente {
        background-color: #b6a345;
    }

    .dashboard_orders div {
        width: calc(100% / 4);
        height: 200px;
        background-color: #2E3858;
        margin-right: 5px;
        margin-left: 5px;
        border-radius: 10px;
        border-bottom: 1px solid #37AB51;
        padding: 10px;
        padding-left: 25px;
    }

    .dashboard_orders div h1 {
        color: white;
        cursor: default;
    }

    .dashboard_orders div h1 span {
        font-size: 50px;
    }

    .dashboard_orders div svg {
        color: white;
        font-size: 30px;
    }

    .table_title {
        width: 100%;
        display: flex;
        align-items: center;
        color: white;
        height: 50px;
        margin-top: 30px;
        cursor: default;
        justify-content: space-between;
    }

    .table_title button {
        width: 100px;
        height: 40px;
        background-color: #202841;
        border: 2px solid #53608B;
        border-radius: 20px;
        cursor: pointer;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }

    td,
    th {
        border: 1px solid #2E3858;
        text-align: center;
        padding: 8px;
    }

    td {
        color: white;
    }

    th {
        background-color: #4D5671;
    }

    @media screen and (max-width: 892px) and (min-width: 10px) {
        .dashboard_orders {
            width: 100%;
            overflow: auto;
        }

        .dashboard_orders div {
            width: 15rem;
            height: auto;
        }

        .dashboard_orders div h1 {
            width: 15rem;
        }

        .dashboard_orders .div_select {
            height: 10rem;
        }

        article {
            width: 100%;
            height: auto;
            overflow: auto;
            padding: 0px;
            margin: 0;
            position: absolute;
            left: 0;
        }
    }
</style>