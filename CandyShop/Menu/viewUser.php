<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CandyShop - User </title>
    <link rel="stylesheet" href="../Menu/menu.css">
    <link rel="stylesheet" href="../Utente/filter.css">
    <link rel="stylesheet" href="../table.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php 
        include("../header.php"); 
        require("../utility.php");
    ?>

    <div class="filtro">
        <form action="../Utente/userFilter.php" method="POST">
            <label for="livelloFedelta"> Livello Fedeltà: </label>
            <select id="livelloFedelta" name="livelloFedelta">
                <option value=""> Seleziona </option>
                <option value="Standard"> Standard </option>
                <option value="Premium"> Premium </option>
                <option value="Gold"> Gold </option>
            </select>

            <label for="nome"> Nome: </label>
            <input type="text" id="nome" name="nome" placeholder="Inserisci il nome" autocomplete="off">

            <label for="iniziale"> Iniziale:</label>
            <input type="text" id="iniziale" name="iniziale" placeholder="Inserisci un'iniziale" autocomplete="off">

            <button type="submit">Filtra</button>
        </form>
    </div>

    <?php
        
        if (isset($_SESSION['query_result']) && $_SESSION['query_result'] !== null) { 
            Utility::createTable($_SESSION['query_result']);
            unset($_SESSION['query_result']);
        }
    ?>
</body>
</html>