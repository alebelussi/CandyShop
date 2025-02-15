<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CandyShop - Carrello </title>
    <link rel="stylesheet" href="orderPage.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php 
        include("../header.php"); 
        include_once "../Negozio/negozio.php";
        include_once "../connectionManager.php";

        $conn = ConnectionManager::getInstance();
        $shop = new Negozio();
    ?>
    <div class="container">
        <h1> Checkout </h1>
        <form action="checkout.php" method="POST">
            <div class="row">
                <div class="column left">
                    <label for="importo">Importo</label>
                    <input type="text" name="importo" value='<?php echo $_SESSION["prezzoTotale"] ?>'>

                    <label for="cittaConsegna">Citta Consegna</label>
                    <input type="text" name="cittaConsegna" id="cittaConsegna" autocomplete="off">

                    <label for="cao">CAP</label>
                    <input type="text" name="cap" id="cap" autocomplete="off">

                    <label for="via">Via</label>
                    <input type="text" name="via" id="via" autocomplete="off">
                </div>

                <div class="column right">
                    <div class="center">
                        <label for="negozio">Negozio</label>
                        <select id="negozio" name="negozio">
                            <option value=""> Seleziona </option>
                            <?php
                                $queryResult = $shop->getShop($conn->getConnection());
                
                                foreach ($queryResult as $row) {
                                    echo "<option value='" . $row['CodiceNegozio'] . "'>" . $row['Nome'] . "</option>";
                                }
                            ?>
                        </select>
    
                        <label for="modalitaSpedizione">Modalita Spedizione</label>
                        <select name="modalitaSpedizione" id="modalitaSpedizione">
                            <option value="Standard"> Standard </option>
                            <option value="Express"> Express </option>
                            <option value="Ritiro in Negozio"> Ritiro in Negozio </option>
                        </select>
                    </div> 
                </div>
            </div>
            <div class="button-container">
                <input type="submit" value="Conferma Ordine">
            </div>
        </form>
    </div>
</body>
</html>
