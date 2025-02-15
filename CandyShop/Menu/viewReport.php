<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyShop - Report </title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="../table.css">
    <link rel="stylesheet" href="viewReport.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body style = "margin-top: 100px">
    <?php 
        include("../header.php"); 
        require("../Ordine/ordine.php");
        require("../connectionManager.php");
        require("../utility.php");
        require("../category.php");

        $conn = ConnectionManager::getInstance();
        $category = new Category();
        $order = new Ordine("", "", "", "", "", "", "", "", "", "","", "");

        session_start();    
    ?>
    <div class="container">
        <h2> PAGINA DEI REPORT </h2>
        <form action="../report.php" method="POST">
            <label for="user"> Seleziona l'utente per calcolare la spesa totale
                <select name="username" id="username">
                    <option value=""> Seleziona </option>
                    <?php
                        $queryResult = $order->getUser($conn->getConnection());
        
                        foreach ($queryResult as $row) {
                            echo "<option value='" . $row['Username'] . "'>" . $row['Username'] . "</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" name="calcolaSpesa" value="Calcola">
        </form>
        <?php
            if(isset($_SESSION['queryResult'][0]) && $_SESSION['queryResult'][0] !== null) { 
                echo "<p class='result'> Spesa totale dell'utente : " . $_SESSION['queryResult'][0] . " € </p>";
                unset($_SESSION['queryResult']);
            }
        ?>

        <form action="../report.php" method="POST">
            <label for="negoziProdotti"> Visualizza i negozi nei quali i prodotti devono essere riforniti </label> 
            <input type="submit" name="negoziProdotti" value="Vedi">
        </form>
        <?php
            if(isset($_SESSION['queryResult'][1]) && $_SESSION['queryResult'][1] != NULL) {
                Utility::createTable($_SESSION['queryResult'][1]);
                unset($_SESSION['queryResult']);
            }
        ?>

        <form action="../report.php" method="POST">
            <label for="calcolaMedia"> Seleziona la categoria per vedere la media dei prodotti venduti
                <select id="codiceCategoria" name="codiceCategoria">
                    <option value=""> Seleziona </option>
                    <?php
                        $queryResult = $category->getCategorySale($conn->getConnection());
        
                        foreach ($queryResult as $row) {
                            echo "<option value='" . $row['CodiceCategoria'] . "'>" . $row['Nome'] . "</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" name="calcolaMedia" value="Calcola">
        </form>
        <?php
            if(isset($_SESSION['queryResult'][2]) && $_SESSION['queryResult'][2] != NULL) {
                Utility::createTable($_SESSION['queryResult'][2]);
                unset($_SESSION['queryResult']);
            }
        ?>

        <form action="../report.php" method="POST">
            <label for="codiceCategoria"> Seleziona la categoria per vedere i negozi che hanno venduto più prodotti <br>
                <select id="codiceCategoria" name="codiceCategoria">
                    <option value=""> Seleziona </option>
                    <?php
                        $queryResult = $category->getCategorySale($conn->getConnection());
        
                        foreach ($queryResult as $row) {
                            echo "<option value='" . $row['CodiceCategoria'] . "'>" . $row['Nome'] . "</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" name="cercaNegozi" value="Calcola">
        </form>
        <?php
            if(isset($_SESSION['queryResult'][3]) && $_SESSION['queryResult'][3] != NULL) {
                Utility::createTable($_SESSION['queryResult'][3]);
                unset($_SESSION['queryResult']);
            }
        ?>

        <form action="../report.php" method="POST">
            <label for="dataOrdine"> Selezionata la data per vedere la quantità venduta dai singoli negozi
                <select id="dataOrdine" name="dataOrdine">
                    <option value=""> Seleziona </option>
                    <?php
                        $queryResult = $order->getOrderDate($conn->getConnection());
        
                        foreach ($queryResult as $row) {
                            echo "<option value='" . $row['DataOrdine'] . "'>" . $row['DataOrdine'] . "</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" value = "Calcola">
        </form>
        <?php
            if(isset($_SESSION['queryResult'][4]) && $_SESSION['queryResult'][4] != NULL) {
                Utility::createTable($_SESSION['queryResult'][4]);
                unset($_SESSION['queryResult']);
            }
        ?>
    </div>
</body>
</html>