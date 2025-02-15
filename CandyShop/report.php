<?php
    require("connectionManager.php");
    require("utility.php");
    require("Ordine/ordine.php");
    require("Negozio/negozio.php");

    $conn = ConnectionManager::getInstance();

    $negozio = new Negozio();

    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcolaSpesa'])) {
        $order = new Ordine("", "", "", "", "", "", "", "", "", "", "", "");

        if (!empty($_POST['username'])) {
            $user = $_POST['username'];
            $_SESSION['queryResult'][0] = $order->totalePrize($conn->getConnection(), $user);
        }
        else 
            $_SESSION['queryResult'][0] = "Nessun utente selezionato.";
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['negoziProdotti'])) 
        $_SESSION['queryResult'][1] = $negozio->addProductAllert($conn->getConnection());
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcolaMedia']))
        $_SESSION['queryResult'][2] = $negozio->avgQuantitySale($conn->getConnection(), $_POST['codiceCategoria']);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cercaNegozi']))
        $_SESSION['queryResult'][3] = $negozio->foundShop($conn->getConnection(), $_POST['codiceCategoria']);
       
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dataOrdine']))
        $_SESSION['queryResult'][4] = $negozio->shopMostSales($conn->getConnection(), $_POST['dataOrdine']);
                
    header("Location: Menu/viewReport.php");
    exit; 
?>
