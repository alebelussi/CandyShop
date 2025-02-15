<?php
    require "product.php";
    require "../connectionManager.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["nome"]) && isset($_POST["prezzo"]) && isset($_POST["quantitaMagazzino"]) && isset($_POST["codiceCategoria"])) {
            $nome = $_POST["nome"];
            $prezzo = $_POST["prezzo"];
            $peso = $_POST["peso"] ?? 0;
            $quantitaMagazzino = $_POST["quantitaMagazzino"];
            $dataScadenza = !empty($_POST["dataScadenza"]) ? $_POST["dataScadenza"] : NULL;
            $percorsoImmagine = $_POST["percorsoImmagine"] ?? NULL;
            $codiceCategoria = $_POST["codiceCategoria"];
        }
    }

    $product = new Product($nome, $prezzo, $peso, $quantitaMagazzino, $dataScadenza, $percorsoImmagine, $codiceCategoria);
    $conn = ConnectionManager::getInstance();

    $product->createTable($conn->getConnection());
    $product->insertProduct($conn->getConnection(), $nome, $prezzo, $peso, $quantitaMagazzino, $dataScadenza, $percorsoImmagine, $codiceCategoria);

    header("Location: ../Menu/homePage.php");
    exit; 
?>