<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyShop - Order </title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="../table.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <div style="margin-top: 100px">
        <?php
            include("../header.php");

            require("../connectionManager.php");
            require("../Ordine/ordine.php");
            require("../utility.php");

            $conn = ConnectionManager::getInstance();

            $order = new Ordine("", "", "", "", "", "", "", "", "", "", "", "");
            Utility::createTable($order->viewOrder($conn->getConnection(), $_SESSION['username']));
        ?>
    </div>
</body>
</html>