<?php
    require "../connectionManager.php";
    require "ordine.php";
    require "carrello.php";

    $conn = ConnectionManager::getInstance();
    
    $order = new Ordine("", "", "", "", "", "","", "", "", "", "", "", "", "");
    $cart = new Carrello("", "", "");

    session_start();

    $cart->deleteOrder($conn->getConnection(), $_SESSION['codiceOrdine']);
    $order->deleteOrder($conn->getConnection(), $_SESSION['codiceOrdine']);

    foreach($_SESSION['prodotto'] as $prodotto)
        $cart->setQuantity($conn->getConnection(), $prodotto['nome'], -($prodotto['quantitaOrdinata']));

    unset($_SESSION['codiceOrdine']);
    unset($_SESSION['prodotto']);
    unset($_SESSION['puntiFedelta']);

    header("Location: ../Menu/carrelloPage.php");
?>