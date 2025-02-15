<?php
    require "product.php";
    require "../connectionManager.php";

    session_start();

    $conn = ConnectionManager::getInstance();
    $product = new Product("", "", "", "", "", "", "", "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
        $codiceCategoria = isset($_POST["categoria"]) ? $_POST["categoria"] : ""; 
    }
    
    $query = "SELECT *
              FROM Prodotto
              WHERE 1";
    
    if (!empty($nome))
        $query .= " AND Nome = '$nome'";

    if (!empty($codiceCategoria))
        $query .= " AND CodiceCategoria = '$codiceCategoria'";

    $result = $product->getProducts($conn->getConnection(), $query);
    
    $_SESSION['query_result'] = $result;
    
    header("Location: ../Menu/viewProduct.php");
    exit;
?>